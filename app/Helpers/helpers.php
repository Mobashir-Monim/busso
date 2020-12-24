<?php

function base64url_encode($data)
{
    $b64 = base64_encode($data);

    if ($b64 == false)
        return false;

    return rtrim(strtr($b64, '+/', '-_'), '=');
}

function base64url_decode($data, $strict = false)
{
    $b64 = strtr($data, '-_', '+/');
    return base64_decode($b64, $strict);
}

function startsWith ($string, $startString) 
{ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
}

function endsWith($string, $endString) 
{ 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
}

function getAdditionalRoles()
{
    $roles = auth()->user()->roles->where('is_system_role', false);

    return [
        'count' => count($roles),
        'roles' => $roles
    ];
}

function printAdditonalRoles()
{
    return implode(", ", getAdditionalRoles()['roles']->pluck('display_name')->toArray());
}

function includes($string, $subString)
{
    return strpos($string, $subString) === false ? false : true;
}

function getStorageDisk()
{
    return env('STORAGE_DISK', 'local');
}