<?php
namespace tlcal\application\processors;

use Eluceo\iCal\Component\Event;
use League\Monga;
use tlcal\domain\models\ical\Calendar as CalendarModel;
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\domain\models\ModelA;

class Calendar extends ProcessorA
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
     * @param HttpRequestA $oHttpRequest
     * @returns ModelA
     */
    public function handleRequest(HttpRequestA $oHttpRequest)
    {
        $connection = Monga::connection('mongodb://127.0.0.1');
        $database = $connection->database('tlcalendar');

        /** @var Monga\Collection $collection */
        $collection = $database->collection('events');
        /** @var Monga\Cursor $cursor */
        $cursor = $collection->find();

        $model = new CalendarModel();
        foreach($cursor->toArray() as $eventArray) {
            $ev = new Event();
            if ($eventArray['start_time']) {
                $start = $eventArray['start_time']->toDateTime();
            }
            if ($eventArray['end_time']) {
                $end = $eventArray['end_time']->toDateTime();
            }

            $ev->setDtStart($start);
            $ev->setDtEnd($end);

            $ev->setSummary($eventArray['category']. ':' . $eventArray['stage']);
            $ev->setDescription($eventArray['content']);

            $model->addEvent($ev);
        }

        return $model;
    }
}
