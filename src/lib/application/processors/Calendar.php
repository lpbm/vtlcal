<?php
namespace tlcal\application\processors;

class Calendar extends \vsc\application\processors\ProcessorA
{
    /**
     * @return void
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * Returns a data model, which can be used in the view
     * @param \vsc\presentation\requests\HttpRequestA $oHttpRequest
     * @returns \vsc\domain\models\ModelA
     */
    public function handleRequest(\vsc\presentation\requests\HttpRequestA $oHttpRequest)
    {
        return new \vsc\domain\models\EmptyModel();
    }
}
