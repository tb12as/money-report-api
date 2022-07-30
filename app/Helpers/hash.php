<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

if (!function_exists('bcrypt')) {
    function bcrypt($str)
    {
        return Hash::make($str);
    }
}

if (!function_exists('enc')) {
    function enc($str)
    {
        return Crypt::encrypt($str);
    }
}


if (!function_exists('decrypt')) {
    function decrypt($str)
    {
        return Crypt::decrypt($str);
    }
}
