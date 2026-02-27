<?php

namespace App\Http\Controllers\Auth\User;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{

    public function register(Request $request)
    {
        //dd($request->all());
        $gs = Generalsetting::findOrFail(1);

        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => [
                'required',
                'regex:/^(\+8801[3-9][0-9]{8}|01[3-9][0-9]{8})$/',
                'unique:users,phone'
            ],
            "address" => "nullable|string|max:200",
            'password' => 'required|confirmed',
        ]);


        $user = new User;
        $input = $request->all();
        $input['password'] = bcrypt($request['password']);
        $token = md5(time() . $request->name . $request->phone);
        $input['verification_link'] = $token;
        $input['affilate_code'] = md5($request->name . $request->phone);
        $input['email'] = rand(1000, 9999) . 'bd@gmail.com';

        $user->fill($input)->save();

        if ($gs->is_verification_email == 1) {
            $to = $request->email;
            $subject = 'Verify your email address.';
            $msg = "Dear Customer,<br>We noticed that you need to verify your email address.<br>Simply click the link below to verify. <a href=" . url('user/register/verify/' . $token) . ">" . url('user/register/verify/' . $token) . "</a>";
            //Sending Email To Customer

            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);

            return back()->with('success', 'We need to verify your email address. We have sent an email to ' . $to . ' to verify your email address. Please click link in that email to continue.');
        } else {

            $user->email_verified = 'Yes';
            $user->update();
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->save();

            // Welcome Email For User

            $data = [
                'to' => $user->email,
                'type' => "new_registration",
                'cname' => $user->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'onumber' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($data);

            Auth::login($user);
            return redirect()->route('user-dashboard')->with('success', __('Registration Successful'));
        }

    }

    public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if ($gs->is_verification_email == 1) {
            $user = User::where('verification_link', '=', $token)->first();
            if (isset($user)) {
                $user->email_verified = 'Yes';
                $user->update();
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->save();

                $data = [
                    'to' => $user->email,
                    'type' => "new_registration",
                    'cname' => $user->name,
                    'oamount' => "",
                    'aname' => "",
                    'aemail' => "",
                    'onumber' => "",
                ];
                $mailer = new GeniusMailer();
                $mailer->sendAutoMail($data);

                Auth::login($user);
                return redirect()->route('user-dashboard')->with('success', __('Email Verified Successfully'));
            }
        } else {
            return redirect()->back();
        }
    }
}
