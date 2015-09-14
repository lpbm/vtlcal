<?php
namespace tlcal\application\processors;

use Eluceo\iCal\Component\Event;
use League\Monga;
use tlcal\domain\models\ical\Calendar as CalendarModel;
use vsc\application\processors\ProcessorA;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpRequestA;
use vsc\domain\models\ModelA;

class Calendar extends ProcessorA
{
    protected $aLocalVars = ['calendar' => 'sc2'];
    /**
     * @return void
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    protected function getTypeFromUrl($var) {
        if ($var == 'dota') {
            return 'dot';
        }
        if ($var == 'league') {
            return 'lol';
        }
        if ($var == 'hearthstone') {
            return 'hrt';
        }
        return 'sc2';
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

        $calendar = $this->getTypeFromUrl($this->getVar('calendar'));
        /** @var Monga\Collection $collection */
        $collection = $database->collection('events');
        /** @var Monga\Cursor $cursor */
        $cursor = $collection->find(
            function ($query) use ($calendar) {
                $lastWeek = (new \DateTime())->sub(new \DateInterval('P1W'));
                /** @var Monga\Query\Find $query */
                $query/*->whereGte('start_time', $lastWeek)*/
                   ->where('type', $calendar);
            }
        );

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

            $ev->setSummary('['. strtoupper($eventArray['type']) . '] ' .  $eventArray['category']. ': ' . $eventArray['stage']);
            $ev->setDescription($eventArray['content']);

            $model->addEvent($ev);
        }

        return $model;
    }
}
