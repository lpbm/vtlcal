<?php
namespace tlcal\application\processors;

use League\Monga;
use tlcal\domain\LiquidAssets;
use tlcal\domain\models\ical\Calendar as CalendarModel;
use tlcal\domain\models\ical\Event;
use vsc\application\processors\ProcessorA;
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

            $doc = new \DOMDocument('1.0', 'UTF-8');

            $root = $doc->createElement('html');
            $doc->appendChild($root);

            $head = $doc->createElement('head');
            $root->appendChild($head);

            $title = $doc->createElement('title');
            $head->appendChild($title);

            $titleText = $doc->createTextNode($eventArray['category']. ': ' . $eventArray['stage']);
            $title->appendChild($titleText);

            $body = $doc->createElement('body');
            $doc->appendChild($body);

            $section = $doc->createElement('section');
            $body->appendChild($section);

            $span = $doc->createElement('span');
            $section->appendChild($span);

            $icon = $doc->createElement('img');
            $icon->setAttribute('src', LiquidAssets::getIconString($eventArray['type']));
            $span->appendChild($icon);

            $localText = clone $titleText;
            $span->appendChild($localText);

            $text = $doc->createTextNode($eventArray['content']);
            $section->appendChild($text);

            $html = $doc->saveHTML();

            $ev->setSummary('['. strtoupper($eventArray['type']) . '] ' . $eventArray['category']. ': ' . $eventArray['stage']);
            $ev->setAltDescription($html, 'application/text');
            $ev->setDescription($eventArray['content']);

            $model->addEvent($ev);
        }

        return $model;
    }
}
