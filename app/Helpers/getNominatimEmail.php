<?php

if (!function_exists('getNominatimEmail')) {
    function getNominatimEmail()
    {
        // Nominatim's Usage Policy
        // @see https://operations.osmfoundation.org/policies/nominatim/
        return env('MAIL_FROM_ADDRESS', new \Exception('No MAIL_FROM_ADDRESS key into your .env'));
    }
}
