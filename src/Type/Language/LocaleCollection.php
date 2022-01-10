<?php

namespace Hurah\Translate\Type\Language;


use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\Json;
use function in_array;
use function is_string;
use function json_encode;
use function var_dump;

class LocaleCollection extends AbstractCollectionDataType
{

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $aLocaleCodes): self
    {
        $oLocaleCollection = new self();
        foreach ($aLocaleCodes as $mCode)
        {
            if (is_string($mCode))
            {
                $oLocaleCollection->addString($mCode);
                continue;
            }
            elseif ($mCode instanceof Locale)
            {
                $oLocaleCollection->add($mCode);
                continue;
            }
            throw new InvalidArgumentException("Expected a type of Locale or a string as argument");
        }

        return $oLocaleCollection;
    }


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
        foreach ($this as $oAvailableLocale)
        {
            if("{$oAvailableLocale}" === "{$oLocale}")
            {
                return;
            }

        }
        $this->array[] = $oLocale;

    }

    /**
     * @throws InvalidArgumentException
     */
    public function toJson():Json
    {
        $aOut = [];
        foreach($this->array as $oLocale)
        {
            $aOut[] = "{$oLocale}";
        }
        return new Json($aOut);
    }

    public function current(): Locale
    {
        return $this->array[$this->position];
    }
}