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
        $var = strtolower($var);
        if ($var == 'dota') {
            return 'dot';
        }
        if ($var == 'csgo' || $var == 'counter' || $var == 'counterstrike') {
            return 'csg';
        }
        if ($var == 'league' || $var == 'lol') {
            return 'lol';
        }
        if ($var == 'hearthstone') {
            return 'hrt';
        }
        if ($var == 'starcraft') {
            return 'sc2';
        }
        if ($var == 'broodwar') {
            return 'brw';
        }
        if ($var == 'smash') {
            return 'sms';
        }
        return 'all';
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
                $lastWeek = (new \DateTime())->sub(new \DateInterval('P1M'));
                /** @var Monga\Query\Find $query */
                $query->whereGte('start_time', new \MongoDate($lastWeek->getTimestamp()));

                if ($calendar != 'all') {
                    $query->where('type', $calendar);
                }
            }
        );

        $model = new CalendarModel($calendar);
        foreach($cursor->toArray() as $eventArray) {
            $ev = new Event();
            if ($eventArray['start_time']) {
                $start = $eventArray['start_time']->toDateTime();
            }
            if ($eventArray['end_time']) {
                $end = $eventArray['end_time']->toDateTime();
            }

            $content = $eventArray['content'];
            if (isset($eventArray['links'])) {
                foreach ($eventArray['links'] as $title => $url) {
                    $content .= "\n" . $title . ': ' . $url;
                }
            }

            $ev->setDtStart($start);
            $ev->setDtEnd($end);

            if (false) {
                $doc = new \DOMDocument('1.0', 'UTF-8');

                $body = $doc->createElement('body');
                $doc->appendChild($body);

                $section = $doc->createElement('div');
                $body->appendChild($section);

                $span = $doc->createElement('span');
                $section->appendChild($span);

                $icon = $doc->createElement('img');
                $icon->setAttribute('src', LiquidAssets::getIconString($eventArray['type']));
                $span->appendChild($icon);

                $br = $doc->createElement('br');
                $span->appendChild($br);

                $localText = $doc->createTextNode($eventArray['category'] . ': ' . $eventArray['stage']);
                $span->appendChild($localText);

                $lines = explode("\n", $content);
                for ($i = count($lines); $i > 0; $i--) {
                    $line = $lines[$i];
                    if (!empty($line)) {
                        $text = $doc->createTextNode($line);
                        $section->appendChild($text);
                        if ($i > 1) {
                            $br = $doc->createElement('br');
                            $section->appendChild($br);
                        }
                    }
                }
                $html = $doc->saveHTML($section);
                $ev->setAltDescription($html, 'text/html');
            }

            if ($calendar == 'all') {
                $ev->setSummary('[' . strtoupper($eventArray['type']) . '] ' . $eventArray['category'] . ': ' . $eventArray['stage']);
            } else {
                $ev->setSummary($eventArray['category'] . ': ' . $eventArray['stage']);
            }
            $ev->setDescription($content);
            if (isset($eventArray['canceled'])) {
                $ev->setCancelled((bool)$eventArray['canceled']);
            }
            $ev->setCategories([LiquidAssets::getLabel($eventArray['type'])]);

            $model->addEvent($ev);
        }

        return $model;
    }
}
