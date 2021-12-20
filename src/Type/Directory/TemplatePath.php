<?php

namespace Hurah\Translate\Type\Directory;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\Path;
use function var_dump;


class TemplatePath
{
    private Path $oTemplatePath;
    private TemplateRoot $oTemplateRoot;

    /**
     * @param TemplateRoot $oTemplateRoot
     * @param string|null $sTemplatePath
     *
     * @throws InvalidArgumentException
     * @throws NullPointerException
     */
    public function __construct(TemplateRoot $oTemplateRoot, ?string $sTemplatePath = null)
    {
        $oTemplatePath = Path::make($sTemplatePath);

        if (!$oTemplatePath->isEmpty())
        {
            if (!$oTemplatePath->hasExtension('twig'))
            {
                throw new InvalidArgumentException("Template path should end with .twig", 1);
            }
            if ($oTemplatePath->isAbsolute())
            {
                throw new InvalidArgumentException("Template path parameter should be be a relative path", 2);
            }
        }

        $this->oTemplatePath = Path::make($sTemplatePath);
        $this->oTemplateRoot = $oTemplateRoot;
    }

    public function getPathComponents(): array
    {
        return $this->oTemplatePath->explode();
    }

    public function getPath(): Path
    {
        return $this->oTemplateRoot->getPath()->extend($this->oTemplatePath);
    }
}