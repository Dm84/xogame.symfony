<?php

namespace Xo\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

use Xo\GameBundle\Model\HydnaLayer as Model;
use Xo\GameBundle\Abstraction;
use Xo\GameBundle\Model\Game;

/**
 * Заглушка для профайлера
 * @author admin
 *
 */

class BaseController extends Controller {
    use ControllerTrait;
    
    /**
     * Модель игры
     * @var Game
     */
    protected $model;
    
    /**
     * Хеширует строку
     * @param string $password
     * @return string
     */
    private function toHash($password)
    {
        return sha1($password);
    }

    /**
     * Возвращает профайлер, либо в случае недосупности - заглушку
     * @return \Xo\GameBundle\Controller\StopWatchStub
     */
    private function GetStopwatch()
    {
        if ($this->has('debug.stopwatch')) {
            return $this->get('debug.stopwatch');
        }

        return new StopWatchStub();
    }

    /**
     * Возвращает проинициализированную модель
     * @param string $locale
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Xo\GameBundle\Model\Game
     */
    public function GetModel($locale, HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->model === null ? new Model(
            $locale, $em, $this->GetStopwatch(),
            $request->cookies->get('login'), $request->cookies->get('hash')) :
            $this->model;
    }

    /**
     * Рендерит шаблон
     * @param string $template
     * @param string $params
     * @return string
     */
    public function RenderTemplate($template, $params)
    {
        return $this->renderView($template, $params);
    }

    /**
     * Генерирует ссылку изходя из маршрута
     * @param string $route
     * @param array $params
     * @return string
     */
    public function MakeUrl($route, $params)
    {
        return $this->generateUrl($route, $params);
    }
    
}
