<?php

if (!function_exists('getNominatimEmail')) {
    function getNominatimEmail()
    {
        // Nominatim's Usage Policy
        // @see https://operations.osmfoundation.org/policies/nominatim/
        return config('mail.from.address', new \Exception('No mail.from.address in your config.'));
    }
}
