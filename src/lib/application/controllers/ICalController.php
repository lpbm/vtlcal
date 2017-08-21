<?php

namespace tlcal\application\controllers;

use tlcal\presentation\views\ICalView;
use vsc\application\controllers\CacheableControllerA;
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\views\ViewA;

class ICalController extends RedisCachedController
{
    /**
     * @returns ViewA
     */
    public function getDefaultView()
    {
        return new ICalView();
    }

    /**
     * @param HttpRequestA $oRequest
     * @param ProcessorA $oProcessor
     * @returns HttpResponseA
     */
    public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
        $oResponse = parent::getResponse($oRequest, $oProcessor);
        $oResponse->addHeader('Content-Disposition', 'attachment; filename="'.$oRequest->getUri().'"');
        return $oResponse;
    }
}
