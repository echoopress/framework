<?php

namespace Demo\Controller;

use Lightyping\Framework\Controller;


class DemoController extends Controller
{
    public function indexAction()
    {
        return $this->response('This is Home Controller.');
    }

    public function welcomeAction($name)
    {
        return $this->render($this->config['path'].'/theme/default/layout.php', array('name' => $name));
    }

    public function postAction()
    {
        $html = '<form method="post"><button>Send Post</button></form><br>';
        return $this->response($html.'Method: '.$this->request->getMethod());
    }

    public function testAction()
    {
        return $this->response('This is test action.');
        //return $this->forward('Homepage\Controller\HomeController::indexAction');
        //return $this->redirect('/welcome/John');
        //return $this->redirectToRoute('/welcome/{name}', array('name'=>'John'));
        //return $this->generateUrl('/test', array('name'=>'Zhang'));
        //return $this->json(array('key'=>'value'));
    }
}