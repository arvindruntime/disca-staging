<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Encryption
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    private static $secretKey;
    private static $secretIv;
    private static $encryptMethod = "AES-256-CBC";

    public function __construct(){
        self::$secretKey= env("SECRET_KEY");
        self::$secretIv= env("SECRET_IV");
    }

    public function handle(Request $request, Closure $next)
    {
        $response =  $next($request);
        $data = json_decode($response->getContent());
        if(isset($data->data) && !isset($data->data->error)){
            $data->data = self::tokenencrypt(json_encode($data->data));
            $response->setContent(json_encode($data));
        }
        // if(isset($data->aaData) && !isset($data->data->error)){
        //     $data->aaData = self::cryptoJsAesEncrypt(self::$secretKey,json_encode($data->aaData));
        //     $response->setContent(json_encode($data));
        // }
        return $response;
    }

    public static function tokenencrypt($data)
    {
        // $result = openssl_encrypt($data, self::$encryptMethod, self::$secretKey, OPENSSL_RAW_DATA, self::$secretIv);
        // return $result = base64_encode($result);

        /* updated by Akash */
        $cipher_key='~OC+b$&!?HJ$%@@E^%@$$Ujs+d$$OC@!';
        $method = 'aes-256-cbc';

        $iv = '~OC+b$&!?HJ$%@@E';
        
        $encrypted = base64_encode(openssl_encrypt($data, $method, $cipher_key, OPENSSL_RAW_DATA, $iv));

        return $encrypted;
    }

    public static function tokendecrypt($data)
    {
        // $result = openssl_decrypt(base64_decode($data), self::$encryptMethod, self::$secretKey, OPENSSL_RAW_DATA, self::$secretIv);
        // return $result;

        /* updated by Akash */
        $cipher_key='~OC+b$&!?HJ$%@@E^%@$$Ujs+d$$OC@!';
        $method = 'aes-256-cbc';

        $iv = '~OC+b$&!?HJ$%@@E';
        
        $decrypted = openssl_decrypt(base64_decode($data), $method, $cipher_key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }

    /**
    * Decrypt data from a CryptoJS json encoding string
    *
    * @param mixed $passphrase
    * @param mixed $jsonString
    * @return mixed
    */
    public static function cryptoJsAesDecrypt($passphrase, $jsonString){
        $jsondata = json_decode($jsonString, true);
        $salt = hex2bin($jsondata["s"]);
        $ct = base64_decode($jsondata["ct"]);
        $iv  = hex2bin($jsondata["iv"]);
        $concatedPassphrase = $passphrase.$salt;
        $md5 = array();
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }

    /**
    * Encrypt value to a cryptojs compatiable json encoding string
    *
    * @param mixed $passphrase
    * @param mixed $value
    * @return string
    */
    public static function cryptoJsAesEncrypt($passphrase, $value){
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx.$passphrase.$salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return json_encode($data);
    }

}
