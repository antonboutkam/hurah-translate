<?php

namespace Test\Hurah\Translate;

use Hurah\Logger\Logger;
use Hurah\Translate\Translate;
use Hurah\Translate\Type\Directory\PathManager;
use Hurah\Translate\Type\Directory\TemplateRoot;
use Hurah\Translate\Type\Directory\TranslationRoot;
use Hurah\Translate\Type\Language\Locale;
use Hurah\Translate\Type\Language\LocaleCollection;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\Path;
use PHPUnit\Framework\TestCase;

class TranslateTest extends TestCase
{
    private Translate $oSiteTranslate;
    private Translate $oCrudTranslate;

    /**
     * @throws InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->getMutualPath()->unlinkRecursive();
        Logger::setLogDir($this->getMutualPath()->extend('log'));
        Logger::setMinLogLevel(Logger::DEBUG);

        $oSitePathManager = new PathManager($this->getTranslationRoot(), $this->getSiteTemplateRoot());
        $this->oSiteTranslate = new Translate($oSitePathManager, $this->getLocaleCollection());

        $oCrudManager = new PathManager($this->getTranslationRoot(), $this->getCrudTemplateRoot());
        $this->oCrudTranslate = new Translate($oCrudManager, $this->getLocaleCollection());
    }


    /**
     * @throws InvalidArgumentException
     * @throws NullPointerException
     */
    public function testTranslateCrudField(): void
    {
        // $this->getTranslationRoot()->getPath()->unlinkRecursive();
        $oToLanguage = new Locale('nl_NL');
        $aSampleTexts = [
            'Product id',
            'Title',
            'Color',
            'Weight',
            'Height',
        ];

        foreach ($aSampleTexts as $sSampleText)
        {
            $this->assertEquals($sSampleText, $this->oCrudTranslate->string($sSampleText, $oToLanguage));
        }
    }

    /**
     * @throws NullPointerException
     * @throws InvalidArgumentException
     */
    public function testSetTranslation():void
    {
        // $this->getTranslationRoot()->getPath()->unlinkRecursive();
        $oToLanguage = new Locale('nl_NL');
        $aSampleTexts = [
            'Product id' => 'Id',
            'Title' => 'Titel',
            'Color' => 'Kleur',
            'Weight' => 'Gewicht',
            'Height' => 'Hoogte',
        ];

        foreach ($aSampleTexts as $sDefaultText => $sSampleTextNl)
        {
            $this->assertEquals($sDefaultText, $this->oCrudTranslate->string($sDefaultText, $oToLanguage));
            $this->oCrudTranslate->set($sDefaultText, $sSampleTextNl, $oToLanguage);
            $this->assertEquals($sSampleTextNl, $this->oCrudTranslate->string($sDefaultText, $oToLanguage));
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testString()
    {
        // $this->getTranslationRoot()->getPath()->unlinkRecursive();

        $oToLanguage = new Locale('nl_NL');
        $sInputText = 'Translated text';
        $sTemplate = 'Projects/Project/page.twig';
        $sTranslatedText = $this->oSiteTranslate->string($sInputText, $oToLanguage, $sTemplate);
        $this->assertEquals($sInputText, $sTranslatedText);
    }

    private function getMutualPath(): Path
    {
        return Path::make(__DIR__)->extend('data');
    }

    private function getRelativeCrudDir(): array
    {
        return [
            'classes',
            'Crud',
            'ProductManager',
            'Field'
        ];
    }

    private function getRelativeSiteDir(): array
    {
        return [
            'public_html',
            'antonboutkam.nl',
            'System',
            'Modules'
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getTranslationRoot(): TranslationRoot
    {
        return new TranslationRoot($this->getMutualPath()->extend('locale-mask', $this->getRelativeSiteDir()));
    }

    private function getCrudTemplateRoot(): TemplateRoot
    {
        return new TemplateRoot($this->getMutualPath()->extend($this->getRelativeCrudDir()));
    }

    /**
     */
    private function getSiteTemplateRoot(): TemplateRoot
    {
        return new TemplateRoot($this->getMutualPath()->extend($this->getRelativeSiteDir()));
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getLocaleCollection(): LocaleCollection
    {
        $oLocaleCollection = new LocaleCollection();
        $oLocaleCollection->addString('nl_NL');
        $oLocaleCollection->addString('da_DK');
        $oLocaleCollection->addString('de_DE');
        $oLocaleCollection->addString('en_US');
        $oLocaleCollection->addString('es_ES');
        $oLocaleCollection->addString('fr_FR');
        return $oLocaleCollection;
    }
}
