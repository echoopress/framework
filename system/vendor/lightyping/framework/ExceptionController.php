<?php

namespace Lightyping\Framework;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

class ExceptionController
{
    public function exceptionAction(FlattenException $exception)
    {
        // todo add html template
        return new Response($exception->getStatusCode().' Error<br>'.$exception->getMessage(),
            $exception->getStatusCode()
        );
    }
}