<?php

namespace Test\Hurah\Translate\Type\Directory;

use Hurah\Translate\Type\Directory\TemplatePath;
use Hurah\Translate\Type\Directory\TemplateRoot;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Path;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Template\Template;

class TemplatePathTest extends TestCase
{

    private function getTemplateRoot():TemplateRoot
    {
        return new TemplateRoot(Path::make(__DIR__, "data", "system", "admin_modules"));
    }
    public function test__constructTwigOnly()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        new TemplatePath($this->getTemplateRoot(),'template/must/have/extension/dot/twig');
    }
    public function test__constructRelativePathsOnly()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        new TemplatePath($this->getTemplateRoot(), '/absolute/path/not/allowed.twig');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testGetPathComponents()
    {
        $oTemplatePath = new TemplatePath($this->getTemplateRoot(), 'valid/template/path.twig');

        $this->assertEquals(['valid', 'template', 'path.twig'], $oTemplatePath->getPathComponents());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testPath()
    {
        $oTemplatePath = new TemplatePath($this->getTemplateRoot(), $sPath = 'valid/template/path.twig');
        $oExpectedPath = $this->getTemplateRoot()->getPath()->extend($sPath);
        $this->assertEquals($oExpectedPath, $oTemplatePath->getPath());
    }

}
