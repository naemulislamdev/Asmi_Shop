<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Marketing push campaigns. Sends a title+body notification to every app user
 * via the FCM topic "all". The actual FCM call is delegated to the self-hosted
 * Node chat-service (it already holds the Firebase service account); we reach it
 * server-to-server on localhost with a short-lived admin JWT (same bridge the
 * live-chat console uses).
 */
class PushCampaignController extends Controller
{
    public function index()
    {
        abort_unless(Auth::guard('admin')->user(), 403);

        $campaigns = DB::table('push_campaigns')->orderByDesc('id')->limit(20)->get();

        return view('admin.marketing-push.index', ['campaigns' => $campaigns]);
    }

    public function send(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        abort_unless($admin, 403);

        $data = $request->validate([
            'title' => 'required|string|max:120',
            'body'  => 'required|string|max:500',
        ]);

        $now = now();
        $id = DB::table('push_campaigns')->insertGetId([
            'title'      => $data['title'],
            'body'       => $data['body'],
            'topic'      => 'all',
            'sent_by'    => $admin->id,
            'status'     => 'pending',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        try {
            $token = $this->mintChatToken($admin->id);
            $resp = Http::timeout(15)
                ->withToken($token)
                ->post('http://127.0.0.1:3001/admin/broadcast', [
                    'title' => $data['title'],
                    'body'  => $data['body'],
                ]);

            $json = $resp->json();
            if ($resp->successful() && ($json['ok'] ?? false)) {
                DB::table('push_campaigns')->where('id', $id)->update([
                    'status'     => 'sent',
                    'message_id' => $json['messageId'] ?? null,
                    'response'   => $resp->body(),
                    'updated_at' => now(),
                ]);
                return back()->with('success', __('Push sent to all app users.'));
            }

            DB::table('push_campaigns')->where('id', $id)->update([
                'status'     => 'failed',
                'response'   => $resp->body(),
                'updated_at' => now(),
            ]);
            return back()->with('error', __('Push failed: ') . ($json['error'] ?? $resp->status()));
        } catch (\Throwable $e) {
            DB::table('push_campaigns')->where('id', $id)->update([
                'status'     => 'failed',
                'response'   => $e->getMessage(),
                'updated_at' => now(),
            ]);
            return back()->with('error', __('Push failed: ') . $e->getMessage());
        }
    }

    /**
     * Mint an HS256 JWT (role:admin) the Node service verifies with the shared
     * JWT_SECRET. Mirrors LiveChatController::mintChatToken.
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
            'exp'  => time() + 600, // 10 min, server-to-server only
        ]));
        $sig = $b64(hash_hmac('sha256', "$header.$payload", $secret, true));

        return "$header.$payload.$sig";
    }
}
