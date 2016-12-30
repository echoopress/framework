<?php

namespace Homepage;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function indexAction(Request $request)
    {
        return new Response('This is Home Controller.');
    }

    public function welcomeAction(Request $request, $name)
    {
        return new Response('Welcome '.$name.' This is Home Controller.');
    }
}