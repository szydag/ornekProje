<?php

namespace App\Helpers;

class EncryptHelper
{
    private static $key = '2149ff0492ae2a83b90181a9e60ce9895b2093fc2b78a81a72a917ba008f8596';

    public static function encrypt($data)
    {
        return base64_encode(openssl_encrypt($data, 'aes-256-cbc', self::$key, 0, substr(self::$key, 0, 16)));
    }

    public static function decrypt($data)
    {
        return openssl_decrypt(base64_decode($data), 'aes-256-cbc', self::$key, 0, substr(self::$key, 0, 16));
    }

    public static function selfEncrypt($data)
    {
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', self::$key, 0, substr(self::$key, 0, 16));
        return self::base64url_encode($encrypted);
    }

    public static function selfDecrypt($data)
    {
        $decoded = self::base64url_decode($data);
        return openssl_decrypt($decoded, 'aes-256-cbc', self::$key, 0, substr(self::$key, 0, 16));
    }

    private static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64url_decode($data)
    {
        $replaced = strtr($data, '-_', '+/');
        return base64_decode(str_pad($replaced, strlen($replaced) % 4 === 0 ? strlen($replaced) : strlen($replaced) + (4 - strlen($replaced) % 4), '=', STR_PAD_RIGHT));
    }

}


