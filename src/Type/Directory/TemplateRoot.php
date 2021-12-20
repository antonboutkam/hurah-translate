<?php

namespace Hurah\Translate\Type\Directory;

use Hurah\Types\Type\Path;

/**
 * Represents the root directory of the templates
 * examples:
 *  <system-root>/admin_modules
 *  <system-root>/classes/Crud
 *  <system-root>/public_html/vangoolstoffenonline.nl/modules
 *  <system-root>/public_html/antonboutkam.nl/System/Modules
 */
class TemplateRoot
{
    private Path $oTemplateRoot;

    public function __construct(Path $oTemplateRoot)
    {
        $this->oTemplateRoot = $oTemplateRoot;
    }
    public function getPath():Path
    {
        return $this->oTemplateRoot;
    }

}