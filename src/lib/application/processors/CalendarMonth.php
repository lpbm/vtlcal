<?php
namespace tlcal\application\processors;

class CalendarMonth extends \vsc\application\processors\ProcessorA
{
    protected $aLocalVars = [
        'year' => null,
        'month' => null
    ];

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
