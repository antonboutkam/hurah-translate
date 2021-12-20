<?php

namespace Hurah\Translate\Type\Language;

use Hurah\Types\Exception\InvalidArgumentException;
use function preg_match;

class Locale
{
    private string $sLocale;
    public function __construct(string $sLocale)
    {
        if(!preg_match('/[a-z]{2}_[A-Z]{2}/', $sLocale))
        {
            throw new InvalidArgumentException("Locale code must follow pattern [a-z]{2}_[A-Z]{2}.");
        }
        $this->sLocale = $sLocale;
    }
    public function __toString()
    {
        return $this->sLocale;
    }

}