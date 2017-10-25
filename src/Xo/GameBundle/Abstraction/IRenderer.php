<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.08.14
 * Time: 20:13
 */

namespace Xo\GameBundle\Abstraction;


interface IRenderer {

    public function RenderTemplate($template, $params);
    public function MakeUrl($route, $params);

}