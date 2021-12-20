<?php

namespace Hurah\Translate\Type\Language;


use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;

class LocaleCollection extends AbstractCollectionDataType
{

    /**
     * @param string $sLocale
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function addString(string $sLocale): void
    {
        $this->array[] = new Locale($sLocale);
    }

    public function add(Locale $oLocale): void
    {
        $this->array[] = $oLocale;
    }


    public function current(): Locale
    {
        return $this->array[$this->position];
    }
}