<?php

namespace App\Helpers;

class Helper
{
    public function base64url_encode($data)
    {
        $b64 = base64_encode($data);

        if ($b64 == false)
            return false;

        return rtrim(strtr($b64, '+/', '-_'), '=');
    }

    public function base64url_decode($data, $strict = false)
    {
        $b64 = strtr($data, '-_', '+/');
        return base64_decode($b64, $strict);
    }

    public function startsWith ($string, $startString) 
    { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    }
  
    public function endsWith($string, $endString) 
    { 
        $len = strlen($endString); 
        if ($len == 0) { 
            return true; 
        } 
        return (substr($string, -$len) === $endString); 
    }
}