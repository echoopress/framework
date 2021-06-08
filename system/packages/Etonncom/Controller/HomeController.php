<?php

namespace Etonncom\Controller;

use Lightyping\Framework\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->response('Homepage');
    }
}
