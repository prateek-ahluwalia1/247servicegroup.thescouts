<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;
use DB;
use Illuminate\Support\Facades\Session;


class GoogleAuthenticator extends Controller
{
    function generateQR(Request $request)
    {
        $qr = DB::table('google2fa_secret')->first();
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $email = 'no-replay@247staffingsolutions.com.au';
        $name = config('custom.title');

        // generate the QR code, indicating the address 
        // of the web application and the user name
        // or email in this case
        $qr_code = $google2fa->getQRCodeInline(
            $name,
            $email,
            $secret
        );
        $inserted = DB::table('google2fa_secret')->where('id', $qr->id)->update([
            'google2fa_secret' => $secret,
            'qr' => $qr_code,
            'created_by' => Session::get('userId')
        ]);
        if ($inserted) {
            return response()->json(['success' => true, 'message' => 'New QR generated successfully.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Fail to generate new QR!']);
        }
    }
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
    public function authenticationQr(Request $request)
    {
        $qr = DB::table('google2fa_secret')->first();
        if(empty($qr)){
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $email = 'no-replay@247staffingsolutions.com.au';
        $name = config('custom.title');

        // generate the QR code, indicating the address 
        // of the web application and the user name
        // or email in this case
        $qr_code = $google2fa->getQRCodeInline(
            $name,
            $email,
            $secret
        );
        DB::table('google2fa_secret')->insert([
            'google2fa_secret' => $secret,
            'qr' => $qr_code,
            'created_by' => Session::get('userId')
        ]);
        }else{
            $qr_code = $qr->qr;
        }
        // store the current secret in the session
        // will be used when we enable 2FA (see below)
        // session([ "2fa_secret" => $secret]);   
        // echo $secret;
         return view('app.2fa', [
            "qr_code" => $qr_code]);
    }
}
