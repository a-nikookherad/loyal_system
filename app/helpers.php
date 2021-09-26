<?php
if (!function_exists("standardMobile")) {
    function standardMobile($input)
    {
        return preg_replace('/(0|98|0098|\+98)(9)([0-9]{9})/', '0$2$3', $input);
    }
}
