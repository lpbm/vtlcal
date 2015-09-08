<?php

namespace tlcal\application\controllers;

use tlcal\presentation\views\ICalView;
use vsc\application\controllers\CacheableControllerA;
use vsc\presentation\views\ViewA;

class ICalController extends CacheableControllerA
{

    /**
     * @returns ViewA
     */
    public function getDefaultView()
    {
        return new ICalView();
    }
}
