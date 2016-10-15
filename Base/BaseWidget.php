<?php


namespace WidgetBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseWidget extends Controller implements WidgetInterface
{

    /**
     * @param $params
     * @return mixed
     */
    protected abstract function getData($params);
}