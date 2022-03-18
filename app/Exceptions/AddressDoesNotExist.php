<?php

namespace App\Exceptions;

use InvalidArgumentException;

class AddressDoesNotExist extends InvalidArgumentException
{
    /**
     * Returns an InvalidArgumentException for the specified uuid
     *
     * @param string $uuid The uuid of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function withId(string $uuid)
    {
        return new static("There is no address with id `{$uuid}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified name
     *
     * @param string $name The name of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function named(string $name)
    {
        return new static("There is no address named `{$name}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified phone
     *
     * @param int|string $phone The phone of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function withPhone(int|string $phone)
    {
        return new static("There is no address with this phone number `{$phone}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified URL
     *
     * @param string $url The URL of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function withWebsite(int $url)
    {
        return new static("There is no address with the URL `{$url}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified osmId
     *
     * @param int $osmId The osmId of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function withOsmId(int $osmId)
    {
        return new static("There is no address with this OpenStreetMap id `{$osmId}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified placeId
     *
     * @param int $placeId The placeId of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function withOsmPlaceId(int $placeId)
    {
        return new static("There is no address with this OpenStreetMap place's id `{$placeId}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified Google Maps +Code
     *
     * @param string $plusCode The Google Maps +Code of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function withPlusCode(string $plusCode)
    {
        return new static("There is no address with this Google Maps +Code `{$plusCode}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified subcategory
     *
     * @param string $subcategory The subcategory of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function forSubcategory(string $subcategory)
    {
        return new static("There is no address for the subcategory `{$subcategory}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified CCA3
     *
     * @param string $cca3 The CCA3 of the unknown address
     *
     * @return AddressDoesNotExist
     */
    public static function forCountry(string $cca3)
    {
        return new static("There is no address for the country`{$cca3}`.");
    }
}
