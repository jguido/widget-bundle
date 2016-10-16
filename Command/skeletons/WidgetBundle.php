<?php

namespace ApplicationWidgetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationWidgetBundle extends Bundle
{
    public function getParent()
    {
        return 'WidgetBundle';
    }
}
