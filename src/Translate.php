<?php

namespace Hurah\Translate;

use Hurah\Logger\Logger;
use Hurah\Translate\Type\Directory\LocaleFile;
use Hurah\Translate\Type\Directory\PathManager;
use Hurah\Translate\Type\Directory\TemplatePath;
use Hurah\Translate\Type\Language\Locale;
use Hurah\Translate\Type\Language\LocaleCollection;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;

final class Translate
{
    private PathManager $oPathManager;
    private LocaleCollection $oLocaleCollection;
    private Logger $oLogger;

    /**
     * @param PathManager $oPathManager
     * @param LocaleCollection $oLocaleCollection
     */
    public function __construct(PathManager $oPathManager, LocaleCollection $oLocaleCollection)
    {
        $this->oPathManager = $oPathManager;
        $this->oLocaleCollection = $oLocaleCollection;
        $this->oLogger = new Logger();
    }

    /**
     * @throws InvalidArgumentException
     * @throws NullPointerException
     */
    public function string(string $sString, Locale $oLanguageTo, ?string $sTemplate = null): string
    {
        $oLocaleFile = $this->getLocaleFile($oLanguageTo, $sTemplate);
        if (!$oLocaleFile->hasTranslation($sString))
        {
            $this->addKey($sString, $sTemplate);
        }
        // $this->oLogger->debug("Get translation {$sString} from {$oLocaleFile}", ['translate']);
        return $oLocaleFile->getTranslation($sString);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addKey(string $sString, ?string $sTemplate = null): void
    {
        foreach ($this->oLocaleCollection as $oLocale)
        {
            $oLocaleFile = $this->getLocaleFile($oLocale, $sTemplate);
            $this->oLogger->info("Adding $sString to $oLocaleFile", ['translate']);
            if(!$oLocaleFile->hasTranslation($sString))
            {
                $oLocaleFile->addKey($sString);
            }

        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function set(string $sSampleText, string $sSampleTextNl, Locale $oToLanguage)
    {
        $this->getLocaleFile($oToLanguage)->set($sSampleText, $sSampleTextNl);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getLocaleFile(Locale $oLocale, ?string $sTemplate = null): LocaleFile
    {
        return new LocaleFile($oLocale, $this->oPathManager->getTranslationRoot(), $sTemplate);
    }

}
