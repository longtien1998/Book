<?php

if (!function_exists('convert_price')) {
    function convert_price(string $price = '', $flag = false){
        return ($flag === false) ? str_replace('.','', $price) : number_format($price, 0, ',', '.');
    }
}
