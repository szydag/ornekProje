<?php

namespace App\Helpers;

class MailEncryptHelper
{
    private static $key = '2149ff0492ae2a83b90181a9e60ce9895b2093fc2b78a81a72a917ba008f8798';

    public static function encrypt($data)
    {
        return base64_encode(openssl_encrypt($data, 'aes-256-cbc', self::$key, 0, substr(self::$key, 0, 16)));
    }

    public static function decrypt($data)
    {
        return openssl_decrypt(base64_decode($data), 'aes-256-cbc', self::$key, 0, substr(self::$key, 0, 16));
    }

}


