<?php

namespace App\Http\Controllers\Auth\Rider;

use App\{
	Models\Rider,
	Models\Notification,
	Classes\GeniusMailer,
	Models\Generalsetting,
	Http\Controllers\Controller
};
use Illuminate\Http\Request;
use Auth;
use Validator;

class RegisterController extends Controller
{

	public function register(Request $request)
	{


		$gs = Generalsetting::findOrFail(1);


		// if ($gs->is_capcha == 1) {
		// 	$request->validate(
		// 		[
		// 			'g-recaptcha-response' => 'required|captcha',
		// 		],
		// 		[
		// 			'g-recaptcha-response.required' => 'Captcha is required.',
		// 			'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
		// 		]
		// 	);
		// }

		$request->validate([
			'name' => 'required',
			'email' => 'required|email|unique:riders',
			"phone" => "required|unique:riders",
			'password' => 'required|confirmed',
		]);

		$rider = new Rider();
		$input = $request->all();
		$input['password'] = bcrypt($request['password']);
		$token = md5(time() . $request->name . $request->email);
		$input['email_token'] = $token;
		$rider->fill($input)->save();

		if ($gs->is_verification_email == 1) {
			$to = $request->email;
			$subject = 'Verify your email address.';
			$msg = "Dear Rider,<br>We noticed that you need to verify your email address.<br>Simply click the link below to verify. <a href=" . url('rider/register/verify/' . $token) . ">" . url('rider/register/verify/' . $token) . "</a>";
			//Sending Email To Rider

			$data = [
				'to' => $to,
				'subject' => $subject,
				'body' => $msg,
			];

			$mailer = new GeniusMailer();
			$mailer->sendCustomMail($data);

			return back()->with('success', 'We need to verify your email address. We have sent an email to ' . $to . ' to verify your email address. Please click link in that email to continue.');

		
		} else {

			$rider->email_verify = 'Yes';
			$rider->update();

			$data = [
				'to' => $rider->email,
				'type' => "new_registration",
				'cname' => $rider->name,
				'oamount' => "",
				'aname' => "",
				'aemail' => "",
				'onumber' => "",
			];
			$mailer = new GeniusMailer();
			$mailer->sendAutoMail($data);
			Auth::guard('rider')->login($rider);
			return redirect()->route('rider-dashboard');
		}
	}

	public function token($token)
	{
		$gs = Generalsetting::findOrFail(1);

		if ($gs->is_verification_email == 1) {
			$rider = Rider::where('email_token', '=', $token)->first();
			if (isset($rider)) {
				$rider->email_verified = 'Yes';
				$rider->update();

				// Welcome Email For User

				$data = [
					'to' => $rider->email,
					'type' => "new_registration",
					'cname' => $rider->name,
					'oamount' => "",
					'aname' => "",
					'aemail' => "",
					'onumber' => "",
				];
				$mailer = new GeniusMailer();
				$mailer->sendAutoMail($data);


				Auth::gurad('rider')->login($rider);
				return redirect()->route('rider-dashboard')->with('success', __('Email Verified Successfully'));
			}
		} else {
			return redirect()->back();
		}
	}
}
