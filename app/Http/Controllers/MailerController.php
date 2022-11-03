<?php

namespace App\Http\Controllers;

use App\Mail\VerifyMail;
use App\Models\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailerController extends Controller
{
        ////////////send email////////////
        public function sendEmail(Request $request)
        {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                'otp'=> 'required'
            ]);
            if($validator->fails())
            {
                return response()->json($validator->errors(),400);
            }
            $pin = $this->generatePin();
            $otp = $this->generateOtp(); 
                    $data = $codeVerification = new Mailer([
                        'email'=>$request->get('email'),
                        'otp' => $request->get('otp'),
                        // 'pin' => $pin
                    ]);
            
                    $data->save();
                    Mail::to($request->email)->send(new VerifyMail($codeVerification));
                    return response()->json($data);
        }
    
            ////////generate otp//////////
    public function generatePin() {
        $pin = '';
        for ($i = 0; $i < 4; $i++) {
            $pin = $pin . mt_rand(0, 9);
        }
    }
    
        ////////generate otp//////////
        public function generateOtp() {
            $otp = '';
            for ($i = 0; $i < 5; $i++) {
                $otp = $otp . mt_rand(0, 9);
            }
            $check = Mailer::where('otp', $otp)->first();
    
            if($check) {
                $this->generatePin();
            } else {
                return $otp;
            }
        }
}
