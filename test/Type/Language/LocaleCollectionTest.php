<?php

namespace Test\Hurah\Translate\Type\Language;

use Hurah\Translate\Type\Language\Locale;
use Hurah\Translate\Type\Language\LocaleCollection;
use Hurah\Types\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LocaleCollectionTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     */
    public function testFromArray(): void
    {
        $oLocaleCollection = LocaleCollection::fromArray([
            'nl_NL',
            new Locale('nl_NL'),
            'de_DE',
            'be_FR'
        ]);

        $this->assertInstanceOf(LocaleCollection::class, $oLocaleCollection);
        $this->assertEquals(3, $oLocaleCollection->length(), $oLocaleCollection->toJson());
    }

    public function testAdd()
    {
        $oLocaleCollection = new LocaleCollection();
        $oLocaleCollection->add(new Locale('nl_NL'));
        $oLocaleCollection->addString('nl_NL');
        $this->assertEquals(2, $oLocaleCollection->length());
    }
}