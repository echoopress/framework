<?php

namespace Homepage\Controller;

use Echoopress\Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction()
    {
        return new Response('This is Home Controller.');
    }

    public function welcomeAction($name)
    {
        return new Response('Welcome '.$name.'!');
    }

    public function postAction(Request $request)
    {
        $html = '<form method="post"><button>Send Post</button></form><br>';
        return new Response($html.'Method: '.$request->getMethod());
    }
}