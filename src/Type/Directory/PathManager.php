<?php

namespace Hurah\Translate\Type\Directory;

class PathManager
{

    private TemplateRoot $oTemplateRoot;
    private TranslationRoot $oTranslationRoot;

    public function __construct(TranslationRoot $oTranslationRoot, TemplateRoot $oTemplateRoot)
    {
        $this->oTemplateRoot = $oTemplateRoot;
        $this->oTranslationRoot = $oTranslationRoot;
    }

    public function getTranslationRoot(): TranslationRoot
    {
        return $this->oTranslationRoot;
    }
    public function getTemplateRoot(): TemplateRoot
    {
        return $this->oTemplateRoot;
    }
}