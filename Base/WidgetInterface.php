<?php

namespace WidgetBundle\Base;


interface WidgetInterface
{
    /**
     * @param array|null $params
     * @return string
     */
    public function getUri(array $params = null);
}