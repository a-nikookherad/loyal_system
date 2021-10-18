<?php

use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

if (!function_exists("standardMobile")) {
    function standardMobile($input)
    {
        return preg_replace('/(0|98|0098|\+98)(9)([0-9]{9})/', '0$2$3', $input);
    }
}

if (!function_exists("validateMobile")) {
    function validateMobile($mobile)
    {
        $mobile = trim($mobile);
        $searchstrings = ["۱", "۲", "٣", "۴", "۵", "۶", "۷", "۸", "۹", "۰", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩", "٠", "۳"];
        $replacestrings = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "3"];
        return str_replace($searchstrings, $replacestrings, $mobile);
    }
}

if (!function_exists("getJti")) {
    function getJti($accessToken = null)
    {
        $bearerToken = $accessToken ?? request()->bearerToken();
        return (new Parser(new JoseEncoder()))->parse($bearerToken)->claims()->get("jti");
    }
}

if (!function_exists("getIdentifier")) {
    function getIdentifier()
    {
        return "identifier_" . request()->ip();
    }
}

