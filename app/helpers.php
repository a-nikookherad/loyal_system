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

if (!function_exists("canonical")) {
    function canonical($postInstance)
    {
        $canonical = [];
        array_push($canonical, $postInstance->slug);
        if (!empty($postInstance->parent_id)) {
            array_push($canonical, $postInstance->parent->slug);
        } elseif (!empty($postInstance->category_id)) {
            array_push($canonical, $postInstance->category->slug);
        }
        $canonical = array_reverse($canonical);
        $canonical = implode("/", $canonical);
        return env("APP_URL") . "/$canonical";
    }
}

if (!function_exists("breadCrumb")) {
    function breadCrumb(\App\Models\Post $postInstance)
    {
        $postsSlugs = [];
        $breadCrumb = "";

        $slug = "";

        array_push($postsSlugs, ["slug" => $postInstance->slug, "breadCrumb" => $postInstance->title]);

        while (!empty($postInstance->parent_id)) {
            $postInstance = $postInstance->parent;
            $canonical .= "/" . $postInstance->slug;
            array_push($postsSlugs, ["slug" => $postInstance->slug, "breadCrumb" => $postInstance->title]);
        }

        //get category slug
        if (!empty($postInstance->category_id) && $postInstance->category->slug !== "unknown") {
            $categoryInstance = $postInstance->category;
            array_push($postsSlugs, ["slug" => $categoryInstance->slug, "breadCrumb" => $categoryInstance->title]);
            while (!empty($categoryInstance->parent_id)) {
                $categoryInstance = $categoryInstance->parent;
                array_push($postsSlugs, ["slug" => $categoryInstance->slug, "breadCrumb" => $categoryInstance->title]);
            }
        }

        foreach ($postsSlugs as $item) {
            $item = array_pop($postsSlugs);
            $slug .= "/" . $item["slug"];
            $breadCrumb .= "/" . $item["breadCrumb"];
        }
        return ["slug" => $slug, "breadCrumb" => $breadCrumb];
    }
}
