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
        public function sendEmail(Request $request,$email)
        {
            $pin = $this->generatePin();
            $otp = $this->generateOtp(); 
                    $codeVerification = [
                        'email'=>$email,
                        'otp' => $otp,
                        'pin' => $pin
                    ];
            
            Mail::to($email)->send(new VerifyMail($codeVerification));
            return response()->json($codeVerification);
        }
    
            ////////generate otp//////////
    public function generatePin() {
        $pin = '';
        for ($i = 0; $i < 4; $i++) {
            $pin = $pin . mt_rand(0, 9);
        }

        return $pin;
    }
    
        ////////generate otp//////////
        public function generateOtp() {
            $otp = '';
            for ($i = 0; $i < 5; $i++) {
                $otp = $otp . mt_rand(0, 9);
            }

            return $otp;
        }
}
