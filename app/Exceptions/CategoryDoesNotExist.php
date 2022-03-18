<?php

namespace App\Exceptions;

use InvalidArgumentException;

class CategoryDoesNotExist extends InvalidArgumentException
{
    /**
     * Returns an InvalidArgumentException for the specified uuid
     *
     * @param string $uuid The uuid of the unknown category
     *
     * @return CategoryDoesNotExist
     */
    public static function withId(string $uuid)
    {
        return new static("There is no category with id `{$uuid}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified name
     *
     * @param string $name The name of the unknown category
     *
     * @return CategoryDoesNotExist
     */
    public static function named(string $name)
    {
        return new static("There is no category named `{$name}`.");
    }

    /**
     * Returns an InvalidArgumentException for the specified slug
     *
     * @param string $slug The slug of the unknown category
     *
     * @return CategoryDoesNotExist
     */
    public static function withSlug(string $slug)
    {
        return new static("There is no category with slug `{$slug}`.");
    }
}
