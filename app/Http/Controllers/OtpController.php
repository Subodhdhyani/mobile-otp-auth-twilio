<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    public function generateOtp(Request $request)
    {
        // Validate phone number (including country code)        
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(), // Get the first error message
            ]);
        }
        $phoneNumber = $request->input('phone_number');
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);
        // Store the phone number and OTP in session
        Session::put('phone_number', $phoneNumber);
        Session::put('otp', $otp);
        try {
            // Use Twilio to send the OTP via SMS
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create(
                $phoneNumber,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Your OTP for verifying your phone number is $otp. Do not share this code with anyone. \n\nThanks & Regards,\nSubodh Dhyani"
                ]
            );
            return response()->json([
                'status'  => 'success',
                'message' => 'OTP send successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., network issues, Twilio errors)
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send OTP: ' . $e->getMessage(),
            ]);
        }
    }

    public function resendOtp()
    {
        // Forget (remove) the existing OTP
        Session::forget('otp');
        $sessionPhoneNumber = Session::get('phone_number');
        // Generate a random 6-digit OTP for resend otp
        $newotp = rand(100000, 999999);
        // Store the new OTP in session
        Session::put('otp', $newotp);
        try {
            // Use Twilio to send the OTP again via SMS
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create(
                $sessionPhoneNumber,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Your OTP for verifying your phone number is $newotp. Do not share this code with anyone. \n\nThanks & Regards,\nSubodh Dhyani"
                ]
            );
            return response()->json([
                'status'  => 'success',
                'message' => 'OTP resend successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., network issues, Twilio errors)
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to resend OTP: ' . $e->getMessage(),
            ]);
        }
    }
    public function verifyOtp(Request $request)
    {
        // Validate the OTP entered
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:6',  // OTP must be 6 digits
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(), // Get the first error message
            ]);
        }
        // Retrieve the OTP from session
        $sessionOtp = Session::get('otp');
        $sessionPhoneNumber = Session::get('phone_number');
        // Retrieve the OTP entered by the user
        $userOtp = $request->input('otp');
        // Check if the entered OTP matches the session OTP and phone number
        if ($sessionOtp && $userOtp == $sessionOtp) {
            // Forget OTP and phone number if otp corect from session before returning response
            Session::forget('phone_number');
            Session::forget('otp');
            // If OTP is valid return success message
            return response()->json([
                'status'  => 'success',
                'message' => 'OTP verified successfully! Your phone number is now verified.',
            ]);
        } else {
            // OTP or phone number mismatch
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP or session has expired.',
            ]);
        }
    }
}
