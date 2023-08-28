<?php

namespace Hurah\Translate\Type\Directory;

use DateTime;
use Hurah\Translate\Type\Language\Locale;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Path;
use Hurah\Types\Util\JsonUtils;
use function count;

final class LocaleFile
{
    private Path $oTemplate;
    private TranslationRoot $oTranslationRoot;
    private Locale $oLocale;

    /**
     * @param Locale $oLocale
     * @param TranslationRoot $oTranslationRoot
     * @param string|null $sTemplate
     *
     * @throws InvalidArgumentException
     */
    public function __construct(Locale $oLocale, TranslationRoot $oTranslationRoot, ?string $sTemplate = null)
    {
        $this->oTemplate = Path::make($sTemplate);
        $this->oTranslationRoot = $oTranslationRoot;
        $this->oLocale = $oLocale;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function hasTranslation(string $sString): bool
    {
        $aTranslation = $this->toArray();
        return isset($aTranslation[$sString]);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getTranslation(string $sString): string
    {
        $aTranslation = $this->toArray();
        return $aTranslation[$sString] ?? $sString;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getLocaleDir(): Path
    {
        $aExtend = [];
        if (count($this->oTemplate->explode()) > 1)
        {
            $aExtend[] = $this->oTemplate->slice(0, 1);
        }
        $aExtend[] = 'Locales';

        $oLocaleDir = $this->oTranslationRoot->getPath()->extend($aExtend);
        if(!$oLocaleDir->isDir())
        {
            $oLocaleDir->makeDir();
        }
        return $oLocaleDir;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getPath(): Path
    {
        return $this->getLocaleDir()->extend("$this->oLocale.json");
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addKey(string $sKey): void
    {
        $aCurrentTranslation = $this->toArray();
        if (!isset($aCurrentTranslation[$sKey]))
        {
            $aNewTranslation = $aCurrentTranslation;
            $aNewTranslation[$sKey] = $sKey;
            $this->writeJson($aNewTranslation, __METHOD__);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function toArray(): array
    {
        if ($this->getPath()->exists())
        {
            return $this->getPath()->getFile()->asJson()->toArray();
        }
        return [];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function __toString(): string
    {
        return "{$this->getPath()}";
    }

    /**
     * @param string $sKey
     * @param string $sTranslation
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function set(string $sKey, string $sTranslation)
    {
        $aCurrentTranslation = $this->toArray();
        $aNewTranslation = $aCurrentTranslation;
        $aNewTranslation[$sKey] = $sTranslation;
        $this->writeJson($aNewTranslation, __METHOD__);
    }

    private function writeJson(array $aTranslation, string $sOrigin = null):void
    {
        $oDateTime = new DateTime();
        $oDateTime->setTimestamp(time());

        $iCount = $aTranslation['_meta']['count'] ?? 0;
        $options = JSON_PRETTY_PRINT;
        $aTranslation['_meta'] = [
            'origin' => $sOrigin,
            'update' => [
                'time' => $oDateTime->format('H:i:s'),
                'date' => $oDateTime->format('Y-m-d')
            ],
            'count' => $iCount + 1
        ];
        $this->getPath()->write(JsonUtils::encode($aTranslation, $options));
    }

}
