<?php

namespace Lightyping\Framework;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;


class Templating extends PhpEngine
{
    public function __construct(TemplateNameParserInterface $parser = null, LoaderInterface $loader = null, $helpers = array())
    {
        if (null === $parser) {
            $parser = new TemplateNameParser();
        }
        if (null === $loader) {
            $loader = new FilesystemLoader(SYSTEM_PATH.'cache/%name%');
        }
        parent::__construct($parser, $loader, $helpers);
    }
}