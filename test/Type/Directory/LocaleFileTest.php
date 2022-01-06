<?php

namespace Test\Hurah\Translate\Type\Directory;

use Hurah\Translate\Type\Directory\LocaleFile;
use Hurah\Translate\Type\Directory\TranslationRoot;
use Hurah\Translate\Type\Language\Locale;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Path;
use PHPUnit\Framework\TestCase;

class LocaleFileTest extends TestCase
{
    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testGetPath(): void
    {
        $sTemplate = 'Projects/Project/page.twig';
        $oLocaleFile = new LocaleFile(new Locale('nl_NL'), $this->getTranslationRoot(), $sTemplate);
        $sExpected = $this->getTranslationRoot()->getPath()->extend('Projects', 'Locales', 'nl_NL.json');
        $this->assertEquals($sExpected, $oLocaleFile->getPath());

    }

    private function getTranslationRoot(): TranslationRoot
    {
        $aRelativeDir = [
            'data',
            'locale-mask',
            'public_html',
            'antonboutkam.nl',
            'System',
            'Modules'
        ];
        $oTemplateRootPath = Path::make(__DIR__)->dirname(3)->extend($aRelativeDir)->makeDir();
        return new TranslationRoot($oTemplateRootPath);
    }
}

