<?php

namespace app\components;

use app\models\AuditHeader;
use app\models\UserLog;
use yii\base\Component;
use Yii;

class Helpers extends Component
{
    function apiPath($module, $action)
    {
        return $this->encrypt($module, 'module') . '/' . $this->encrypt($action, 'action');
    }

    function urlSafeBase64Encode($data)
    {
        $encodedData = base64_encode($data);
        return str_replace(['+', '/', '='], ['-', '_', ''], $encodedData);
    }

    function urlSafeBase64Decode($data)
    {
        $decodedData = str_replace(['-', '_'], ['+', '/'], $data);
        return base64_decode($decodedData);
    }

    function encrypt($data, $key)
    {
        $method = 'aes-256-cbc';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        return $this->urlSafeBase64Encode($iv . $encrypted);
    }

    function decrypt($data, $key)
    {
        $method = 'aes-256-cbc';
        $data = $this->urlSafeBase64Decode($data);
        $iv_length = openssl_cipher_iv_length($method);
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);
        return openssl_decrypt($encrypted, $method, $key, 0, $iv);
    }

}
