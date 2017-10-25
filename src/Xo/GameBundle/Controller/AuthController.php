<?php

namespace Xo\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

use Xo\GameBundle\View\XoView;
use Xo\GameBundle\Abstraction\IRenderer;

/**
 * Контроллер авторизации
 */
class AuthController extends Controller implements IRenderer {
    use ControllerTrait;

    /**
     * Выход, деавторизация
     * @param string $locale
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return HttpFoundation\Response
     */
    public function signoutAction($locale, HttpFoundation\Request $request)
    {
        $response = $this->redirect($this->generateUrl("main", array('locale' => $locale)));
        $response->headers->clearCookie('login');
        $response->headers->clearCookie('hash');
        
        return $response;
    }    
    
    /**
     * Авторизация
     * @param string $locale
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return HttpFoundation\Response
     */
    public function signinAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);

        $login = $request->get('login');
        $hash = $this->toHash($request->get('password'));

        $signinResult = $model->Signin($login, $hash);
        $view = new XoView($model, $this);
        
        if ($signinResult === true)
        {            
            $view->SetCookies($login, $hash);
            
            $response = new \stdClass();
            $response->login = $login;
            $response->html = $model->HandleState($view);
            
        } else
        {
            $response = null;
        }

        return $view->FormJsonResponse($response);
    }
    
    public function signupAction($locale, HttpFoundation\Request $request)
    {
        $model = $this->GetModel($locale, $request);

        $login = $request->get('login');
        $hash = $this->toHash($request->get('password'));            

        $model->Signup($login, $hash);

        $view = new XoView($model, $this);
        $view->SetCookies($login, $hash);

        $response = new \stdClass();
        $response->html = $model->HandleState($view);
        $response->login = $login;

        return $view->FormJsonResponse($response);
    }
    
}
