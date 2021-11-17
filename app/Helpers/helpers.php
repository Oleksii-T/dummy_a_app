<?php

if ( !function_exists('cardImage') ) {
    function cardImage($brand)
    {
        switch (strtolower($brand)) {
            case 'visa':
                return asset('assets/website/img/metods-1.png');
            case 'mastercard':
                return asset('assets/website/img/metods-2.png');
            case 'discover':
                return asset('assets/website/img/metods-3.png');
            default:
                return null;
        }
    }
}