<?php
namespace tlcal\domain\access\mongo;

use tlcal\domain\LiquidAssets;
use tlcal\domain\models\ical\Calendar as CalendarModel;
use tlcal\domain\models\ical\Event;
use MongoDB\Driver\Manager as MongoManager;
use MongoDB\Collection as MongoCollection;
use MongoDB\BSON\UTCDateTime as MongoDateTime;

class MongoCalendar
{
    private $connection;

    public function __construct()
    {
        $this->connection = new MongoManager('mongodb://127.0.0.1');
    }

    /**
     * @param array $calendars
     * @param array $dates
     * @param bool $html
     */
    public function loadCalendars(array $calendars, array $dates = [], bool $html = false)
    {
        $collection = new MongoCollection($this->connection, 'tlcalendar', 'events');
        list($startDate, $endDate) = $dates;
        $query = [];

        if ($startDate instanceof \DateTimeImmutable) {
            $query['end_time'] = ['$gte' => new MongoDateTime($startDate->getTimestamp())];
        }
        if ($endDate instanceof \DateTimeImmutable) {
            $query['start_time'] = ['$lt' => new MongoDateTime($endDate->getTimestamp())];
            $query = [
                '$and' => [
                    [
                        'end_time' => ['$gte' => new MongoDateTime($startDate->getTimestamp())],
                    ],
                    //[
                    //    'start_time' => ['$lt' => new MongoDateTime($endDate->getTimestamp())]
                    //]
                ]
            ];
            unset($query['end_time']);
        }
        if (count($calendars) == 1) {
            if ($calendars[0] != 'all') {
                $query['$and'][] = ['type' => $calendars[0]];
            }
        }

        $cursor = $collection->find($query, ['sort' => ['start_time' => -1]]);

        $model = new CalendarModel($calendars);
        foreach($cursor as $event) {
            $ev = new Event(md5($event->type . ':' . $event->_id));
            if ($event->start_time) {
                $start = $event->start_time->toDateTime();
            }
            if ($event->end_time) {
                $end = $event->end_time->toDateTime();
            }

            $content = $event->content;
//            if (isset($event->links)) {
//                foreach ($event->links as $title => $url) {
//                    $content .= "\n" . $title . ': ' . $url;
//                }
//            }

            $ev->setDtStart($start);
            $ev->setDtEnd($end);

            if ($html) {
                $doc = new \DOMDocument('1.0', 'UTF-8');

                $body = $doc->createElement('body');
                $doc->appendChild($body);

                $section = $doc->createElement('div');
                $body->appendChild($section);

                $span = $doc->createElement('span');
                $section->appendChild($span);

                $icon = $doc->createElement('img');
                $icon->setAttribute('src', LiquidAssets::getIconString($event->type));
                $span->appendChild($icon);

                $br = $doc->createElement('br');
                $span->appendChild($br);

                $localText = $doc->createTextNode($event->category . ': ' . $event->stage);
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
                $htmlDescription = $doc->saveHTML($section);
                $ev->setAltDescription($htmlDescription, 'text/html');
            }

            $summary = '[' . strtoupper($event->type) . '] ' . $event->category;
            if (!empty($event->stage)) {
                $summary .= ': ' . $event->stage;
            }
            if (!empty($content)) {
                $lines = explode("\n", $content);
                if (count($lines) == 1) {
                    $summary .= ': ' . $lines[0];
                }
            }
            $ev->setSummary($summary);

            $ev->setDescription($content);
            if (isset($event->canceled)) {
                $ev->setCancelled((bool)$event->canceled);
            }
            $ev->setCategories([LiquidAssets::getLabel($event->type)]);

            $model->addEvent($ev);
        }

        return $model;
    }
}