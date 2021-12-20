<?php

namespace Hurah\Translate\Type\Directory;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Path;

class TranslationRoot
{
    private Path $oDirectory;

    /**
     * @param string $sDirectoryName
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $sDirectoryName)
    {
        $this->oDirectory = Path::make($sDirectoryName);
    }
    public function getPath():Path
    {
        return $this->oDirectory;
    }

}