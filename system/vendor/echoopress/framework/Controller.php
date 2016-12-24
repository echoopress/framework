<?php
/**
 * Controller.php
 */

namespace Echoopress\Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function indexAction(Request $request, $name)
    {
        return new Response('Test Controller.'.$name);
    }
}