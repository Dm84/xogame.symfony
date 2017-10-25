<?php

namespace Xo\GameBundle\Controller;

use Symfony\Component\HttpFoundation;

use Xo\GameBundle\Model\HydnaLayer as Model;

class StopWatchStub {
    
    public function start($name) {}
    public function stop($name) {}
}

trait ControllerTrait {
    
    protected $model;
    
    private function toHash($password)
    {
        return sha1($password);
    }

    private function GetStopwatch()
    {
        if ($this->has('debug.stopwatch')) {
            return $this->get('debug.stopwatch');
        }

        return new StopWatchStub();
    }

    private function GetModel($locale, HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->model === null ? new Model(
            $locale, $em, $this->GetStopwatch(),
            $request->cookies->get('login'), $request->cookies->get('hash')) :
            $this->model;
    }

    public function RenderTemplate($template, $params)
    {
        return $this->renderView($template, $params);
    }

    public function MakeUrl($route, $params)
    {
        return $this->generateUrl($route, $params);
    }
    
}
