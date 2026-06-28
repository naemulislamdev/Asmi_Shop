<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Mint a short-lived guest chat token for the self-hosted Node chat
     * service (verified there with the shared JWT_SECRET). Name + phone are
     * captured in the app's pre-chat form so agents can identify/contact the
     * guest. Throttled at the route to limit abuse.
     */
    public function guestToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guest_id' => 'required|string|max:64',
            'name'     => 'required|string|max:100',
            'phone'    => ['required', 'regex:/^(\+8801[3-9][0-9]{8}|01[3-9][0-9]{8})$/'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
        }

        $token = $this->mint(
            trim($request->guest_id),
            trim($request->name),
            trim($request->phone)
        );

        return response()->json(['status' => true, 'data' => ['token' => $token], 'error' => []]);
    }

    /** Manually sign an HS256 JWT (no extra package) — Node verifies it. */
    private function mint($gid, $name, $phone): string
    {
        $secret = env('JWT_SECRET');
        $b64 = fn ($x) => rtrim(strtr(base64_encode($x), '+/', '-_'), '=');

        $header  = $b64(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload = $b64(json_encode([
            'role'  => 'guest',
            'gid'   => $gid,
            'name'  => $name,
            'phone' => $phone,
            'iat'   => time(),
            'exp'   => time() + 7 * 24 * 3600, // 7 days — guest keeps history on this device
        ]));
        $sig = $b64(hash_hmac('sha256', "$header.$payload", $secret, true));

        return "$header.$payload.$sig";
    }
}
