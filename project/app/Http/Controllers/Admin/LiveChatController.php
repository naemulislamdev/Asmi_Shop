<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveChatController extends Controller
{
    /**
     * Live chat console for admins. The chat realtime/REST runs on the
     * self-hosted Node service behind https://asmishop.com/chat. The admin
     * panel uses session auth, so here we mint a short-lived JWT (signed with
     * the SAME JWT_SECRET the Node service verifies) carrying role:'admin'.
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        abort_unless($admin, 403);

        $token = $this->mintChatToken($admin->id);

        return view('admin.livechat.index', [
            'chatBase'   => '/chat',                 // nginx path -> Node service
            'socketPath' => '/chat/socket.io',
            'chatToken'  => $token,
            'adminName'  => $admin->name ?? 'Admin',
            'contextUrl' => route('admin.chat.context'),
        ]);
    }

    /**
     * Customer context for the chat side-panel: profile + order stats + recent
     * orders, looked up by user_id (logged-in customer) and/or phone (guest).
     * Admin-only. Returns plain JSON for the admin chat console JS.
     */
    public function customerContext(Request $request)
    {
        abort_unless(Auth::guard('admin')->user(), 403);

        $userId = $request->get('user_id');
        $phone  = $request->get('phone');
        $last10 = $phone ? substr(preg_replace('/\D/', '', $phone), -10) : null;

        if (!$userId && !$last10) {
            return response()->json(['status' => false, 'error' => 'no identifier'], 422);
        }

        // Orders matched by user_id OR by phone (covers guests + accounts).
        $ordersQ = Order::query()->where(function ($q) use ($userId, $last10) {
            if ($userId) {
                $q->orWhere('user_id', $userId);
            }
            if ($last10) {
                $q->orWhere('customer_phone', 'like', '%' . $last10);
            }
        });

        $total   = (clone $ordersQ)->count();
        $spent   = (clone $ordersQ)->sum('pay_amount');
        $recent  = (clone $ordersQ)->orderByDesc('id')->limit(6)
            ->get(['order_number', 'pay_amount', 'status', 'created_at']);

        // Profile: prefer the user account, else fall back to latest order info.
        $user = $userId ? User::find($userId)
            : ($last10 ? User::where('phone', 'like', '%' . $last10)->first() : null);
        $latest = (clone $ordersQ)->orderByDesc('id')->first();

        $profile = [
            'name'  => $user->name ?? $latest->customer_name ?? null,
            'phone' => $user->phone ?? $latest->customer_phone ?? $phone,
            'email' => $user->email ?? $latest->customer_email ?? null,
            'is_registered' => (bool) $user,
        ];

        return response()->json([
            'status'  => true,
            'profile' => $profile,
            'stats'   => ['orders' => $total, 'spent' => round((float) $spent)],
            'recent'  => $recent,
        ]);
    }

    /**
     * Manually sign an HS256 JWT (no extra package) — Node verifies it with
     * jsonwebtoken using the shared secret.
     */
    private function mintChatToken($adminId): string
    {
        $secret = env('JWT_SECRET');
        $b64 = fn ($x) => rtrim(strtr(base64_encode($x), '+/', '-_'), '=');

        $header  = $b64(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload = $b64(json_encode([
            'sub'  => (int) $adminId,
            'role' => 'admin',
            'iat'  => time(),
            'exp'  => time() + 8 * 3600, // 8h shift
        ]));
        $sig = $b64(hash_hmac('sha256', "$header.$payload", $secret, true));

        return "$header.$payload.$sig";
    }
}
