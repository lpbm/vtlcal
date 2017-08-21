<?php

namespace tlcal\application\controllers;

use tlcal\presentation\views\ICalView;
use tlcal\presentation\views\PlainTextView;
use vsc\application\controllers\CacheableControllerA;
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\views\ViewA;

class PlainTextController extends ICalController
{

    /**
     * @returns ViewA
     */
    public function getDefaultView()
    {
        return new PlainTextView();
    }

    /**
     * @param HttpRequestA $oRequest
     * @param ProcessorA $oProcessor
     * @return \vsc\presentation\responses\HttpResponseA
     */
    public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
        return RedisCachedController::getResponse($oRequest, $oProcessor);
    }
}
