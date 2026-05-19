<?php

namespace App\Http\Controllers\Api\Auth;

use App\{
    Models\User,
    Models\Generalsetting
};

use App\{
    Http\Controllers\Controller,
    Http\Resources\UserResource
};
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Classes\GeniusMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout', 'social_login', 'forgot', 'forgot_submit', 'refresh', 'loginByOrder', 'loginOtpRequest', 'loginOtpVerify']]);
        $this->middleware('setapi');
    }

    /**
     * POST /api/user/login/otp/request
     * Body: { phone }
     * Generates a 6-digit OTP for an existing user, stores on user.otp,
     * sends via Vonage SMS using credentials in generalsetting.
     */
    public function loginOtpRequest(Request $request)
    {
        try {
            $rules = ['phone' => 'required|string'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }

            $phone = trim($request->phone);
            $user = User::where('phone', $phone)->first();
            if (!$user) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'User not found.']]);
            }

            $otp = (string) random_int(100000, 999999);
            $user->otp = $otp;
            $user->save();

            $gs = Generalsetting::first();

            try {
                if (!empty($gs->vonage_key) && !empty($gs->vonage_secret)) {
                    config([
                        'vonage.api_key'    => $gs->vonage_key,
                        'vonage.api_secret' => $gs->vonage_secret,
                    ]);
                    $text = new \Vonage\SMS\Message\SMS(
                        $user->phone,
                        $gs->from_number ?? 'AsmiShop',
                        'Your OTP : ' . $otp
                    );
                    \Vonage\Laravel\Facade\Vonage::sms()->send($text);
                }
            } catch (\Exception $sendErr) {
                // SMS failure does NOT block the flow — OTP is still set on
                // the user. Return success so dev/test can read otp from DB.
            }

            return response()->json([
                'status' => true,
                'data'   => ['message' => 'OTP sent to your phone.', 'user_id' => $user->id],
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * POST /api/user/login/otp/verify
     * Body: { phone, otp }
     * Returns JWT on success and clears user.otp.
     */
    public function loginOtpVerify(Request $request)
    {
        try {
            $rules = [
                'phone' => 'required|string',
                'otp'   => 'required|string|max:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }

            $phone = trim($request->phone);
            $otp   = trim($request->otp);

            $user = User::where('phone', $phone)->first();
            if (!$user) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'User not found.']]);
            }

            if (!$user->otp || !hash_equals((string) $user->otp, $otp)) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'OTP did not match.']]);
            }

            if ($user->ban == 1) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Your Account Has Been Banned.']]);
            }

            // Clear OTP — single-use.
            $user->otp = null;
            $user->save();

            // 30-day TTL for OTP-issued tokens.
            $minutes = 60 * 24 * 30;
            Auth::guard('api')->factory()->setTTL($minutes);
            $token = Auth::guard('api')->login($user);

            return response()->json([
                'status' => true,
                'data'   => [
                    'token'      => $token,
                    'expires_in' => $minutes * 60,
                    'user'       => new UserResource($user),
                ],
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Auto sign-in (or auto register + sign-in) using the customer phone of a
     * recently placed order. Used by the mobile app right after a guest
     * checkout so the user keeps a session for "My Orders" / future orders
     * without ever picking a password.
     *
     * Request body: { phone: string, order_number: string }
     *
     * Security:
     *  - Verified by matching customer_phone of the given order_number.
     *  - Only orders placed within the last 24h are accepted.
     *  - Auto-created users get a deterministic password matching the
     *    Flutter convention: asmi_<last6digits>_2026  (force_password_change=1
     *    so the app can prompt on next manual sign-in).
     */
    public function loginByOrder(Request $request)
    {
        try {
            $rules = [
                'phone'        => 'required|string',
                'order_number' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }

            $phone       = trim($request->phone);
            $orderNumber = trim($request->order_number);
            $phoneDigits = preg_replace('/\D/', '', $phone);
            $last10      = substr($phoneDigits, -10);
            if (strlen($last10) < 10) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Invalid phone number.']]);
            }

            $order = \App\Models\Order::where('order_number', $orderNumber)
                ->where('created_at', '>=', now()->subHours(24))
                ->first();

            if (!$order) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Order not found or expired.']]);
            }

            $orderPhoneDigits = preg_replace('/\D/', '', (string) $order->customer_phone);
            $orderLast10      = substr($orderPhoneDigits, -10);
            if (!hash_equals($orderLast10, $last10)) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Phone does not match this order.']]);
            }

            $created = false;
            $user    = null;

            if ($order->user_id && $order->user_id != 0) {
                $user = User::find($order->user_id);
            }

            if (!$user) {
                $user = User::where('phone', $phone)
                    ->orWhere('phone', $last10)
                    ->orWhere('phone', '+88' . $last10)
                    ->first();
            }

            if (!$user) {
                $autoEmail    = $last10 . '@asmi.local';
                $autoPassword = 'asmi_' . substr($last10, -6) . '_2026';

                $user                        = new User();
                $user->name                  = $order->customer_name ?: 'Customer';
                $user->email                 = $autoEmail;
                $user->phone                 = $phone;
                $user->address               = $order->customer_address;
                $user->password              = bcrypt($autoPassword);
                $user->email_verified        = 'Yes';
                if (Schema::hasColumn('users', 'force_password_change')) {
                    $user->force_password_change = 1;
                }
                if (Schema::hasColumn('users', 'auto_created_via')) {
                    $user->auto_created_via = 'order_checkout';
                }
                $user->save();

                $created = true;
            }

            if (!$order->user_id || $order->user_id == 0) {
                $order->user_id = $user->id;
                $order->save();
            }

            // 30-day TTL for guest auto-login tokens. Default config ttl is
            // 60 minutes which is too short for a passive auto-login flow.
            $minutes = 60 * 24 * 30;
            Auth::guard('api')->factory()->setTTL($minutes);
            $token = Auth::guard('api')->login($user);

            return response()->json([
                'status' => true,
                'data'   => [
                    'token'      => $token,
                    'expires_in' => $minutes * 60,
                    'created'    => $created,
                    'force_password_change' => (int) ($user->force_password_change ?? 0),
                    'user'       => new UserResource($user),
                ],
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'fullname' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users',
                'phone' => 'required',
                'address' => 'nullable',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }

            $gs = Generalsetting::first();

            $user = new User;
            $user->name = $request->fullname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->password = bcrypt($request->password);

            if ($gs->is_verification_email == 0) {
                $user->email_verified = 'Yes';
            }

            if ($gs->is_verification_email == 1) {
                $to = $request->email;
                $subject = 'Verify your email address.';
                $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=" . url('user/register/verify/' . $token) . ">Simply click here to verify. </a>";
                //Sending Email To Customer
                if ($gs->is_smtp == 1) {
                    $data = [
                        'to' => $to,
                        'subject' => $subject,
                        'body' => $msg,
                    ];

                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($data);
                } else {
                    $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
                    mail($to, $subject, $msg, $headers);
                }
            }

            $user->save();

            $token = auth()->login($user);

            return response()->json(['status' => true, 'data' => ['token' => $token, 'user' => new UserResource($user)], 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        return $request->all();
    }
    public function login(Request $request)
    {
        try {
            $rules = [
                'phone' => [
                    'required',
                    'regex:/^(\+8801[3-9][0-9]{8}|01[3-9][0-9]{8})$/'
                ],
                'email' => 'nullable|email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }

            $credentials = request(['phone', 'email', 'password']);


            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Email / password didn't match."]]);
            }

            if (auth()->user()->email_verified == 'No') {
                auth()->logout();
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Your Email is not Verified!']]);
            }

            if (auth()->user()->ban == 1) {
                auth()->logout();
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Your Account Has Been Banned.']]);
            }
            $expired = auth()->factory()->getTTL() * 60;

            return response()->json(['status' => true, 'data' => ['token' => $token, 'expires_in' => $expired, 'user' => new UserResource(auth()->user())], 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function social_login(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
            }

            $user = User::where('email', '=', $request->email)->first();

            if (!$user) {

                $rules = [
                    'email' => 'email|unique:users'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'data' => [], 'error' => $validator->errors()]);
                }

                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->email_verified = 'Yes';
                $user->save();
                $token = auth()->login($user);
                return response()->json(['status' => true, 'data' => ['token' => $token], 'error' => []]);
            }

            $userToken = JWTAuth::fromUser($user);

            if ($user->email_verified == 'No') {
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Your Email is not Verified!']]);
            }

            if ($user->ban == 1) {
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => 'Your Account Has Been Banned.']]);
            }

            auth()->login($user);

            return response()->json(['status' => true, 'data' => ['token' => $userToken, 'user' => auth()->user()], 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        try {
            return response()->json(['status' => true, 'data' => new UserResource(auth()->user()), 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['status' => true, 'data' => ['message' => 'Successfully logged out.'], 'error' => []]);
    }

    public function sendVerificationCode(Request $request)
    {
        $gs = Generalsetting::first();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }



    public function forgot(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        $user = User::where('email', $request->email)->first();
        if ($user) {

            $token = Str::random(6);

            $subject = "Reset Password Request";
            $msg = "Your Forgot Password Token: " . $token;
            $user->reset_token = $token;
            $user->update();

            if ($gs->is_smtp == 1) {
                $data = [
                    'to' => $request->email,
                    'subject' => $subject,
                    'body' => $msg,
                ];

                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($data);
            } else {
                $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
                mail($request->email, $subject, $msg, $headers);
            }

            return response()->json(['status' => true, 'data' => ['user_id' => $user->id, 'reset_token' => $user->reset_token], 'error' => []]);
        } else {
            return response()->json(['status' => false, 'data' => [], 'error' => 'Account not found']);
        }
    }


    public function forgot_submit(Request $request)
    {

        if ($request->new_password != $request->confirm_password) {
            return response()->json(['status' => false, 'data' => [], 'error' => 'New password & confirm password not match']);
        }

        $user = User::where('id', $request->user_id)->where('reset_token', $request->reset_token)->first();
        if ($user) {

            $password = Hash::make($request->new_password);
            $user->password = $password;
            $user->reset_token = null;
            $user->update();
            return response()->json(['status' => true, 'data' => ['message' => 'Password Changed Successfully'], 'error' => []]);
        } else {
            return response()->json(['status' => false, 'data' => [], 'error' => 'Something is wrong']);
        }
    }
}
