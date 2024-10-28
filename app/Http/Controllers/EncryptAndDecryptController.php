<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptAndDecryptController extends Controller
{
    public function encryptAndDecrypt(){
        return view("encrypt");
    }


    public function encrypt(Request $request) {
        $plaintext = $request->encrypt;
        $key = "base64:6za6j6UdB5j11TX/mHZzHOsjyON5pki9Wm12660KZeg=";
        $key = substr(hash('sha256', $key, true), 0, 32);

        $iv = openssl_random_pseudo_bytes(16);

        $encrypted = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        $encryptedData = $iv . $encrypted;

        $hexOutput = bin2hex($encryptedData);

        $base64Output = base64_encode($encryptedData);

        return [
            'hex' => $hexOutput,
            'base64' => $base64Output,
        ];
    }

    public function decrypt(Request $request) {
        $encryptedData= $request->decrypt;
        $key = "base64:6za6j6UdB5j11TX/mHZzHOsjyON5pki9Wm12660KZeg=";

        $format = 'base64';

        $key = substr(hash('sha256', $key, true), 0, 32);

        if ($format === 'hex') {
            $encryptedData = hex2bin($encryptedData);
        } elseif ($format === 'base64') {
            $encryptedData = base64_decode($encryptedData);
        }

        $iv = substr($encryptedData, 0, 16); 
        $encryptedText = substr($encryptedData, 16); 

        $decrypted = openssl_decrypt($encryptedText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
        }
}
