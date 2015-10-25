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
    protected $aLocalVars = [
        'calendar' => 'sc2',
        'year' => null,
        'month' => null,
        'day' => null
    ];
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
        if ($var == 'cs'  || $var == 'cs:go' || $var == 'csgo' || $var == 'counter' || $var == 'counterstrike') {
            return 'csg';
        }
        if ($var == 'league' || $var == 'lol') {
            return 'lol';
        }
        if ($var == 'hearthstone') {
            return 'hrt';
        }
        if ($var == 'starcraft' || $var == 'sc2') {
            return 'sc2';
        }
        if ($var == 'broodwar' || $var == 'bw') {
            return 'brw';
        }
        if ($var == 'smash') {
            return 'sms';
        }
        return 'all';
    }

    /**
     * @return array
     */
    private function getDates() {
        $year = $this->getVar('year');
        $month = $this->getVar('month');
        $day = $this->getVar('day');

        if (!($year || $month || $day)) {
            return [
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d',
                    (new \DateTimeImmutable())->format('Y-m-01')
                ),
                null
            ];
        }
        if (is_null($day)) {
            $interval = 'P1M';
            $dateString = '%s-%s-01 00:00:00';
        } else {
            $interval = 'P1D';
            $dateString = '%s-%s-%s 00:00:00';
        }

        if (!is_numeric($month)) {
            if (strlen($month) == 3) {
                $format = 'Y-M-d G:i:s';
            } else {
                $format = 'Y-F-d G:i:s';
            }
            $date = sprintf($dateString, $year, ucfirst($month), $day);

        } else {
            $format = 'Y-m-d G:i:s';
            $date = sprintf($dateString, $year, $month, $day);
        }

        $start = \DateTimeImmutable::createFromFormat($format, $date);
        return [$start, $start->add(new \DateInterval($interval))];
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
        list($startDate, $endDate) = $this->getDates();
        if ($startDate instanceof \DateTimeImmutable) {
            /** @var Monga\Cursor $cursor */
            $cursor = $collection->find(
                function ($query) use ($calendar, $startDate, $endDate) {
                    /** @var Monga\Query\Find $query */
                    $query->whereGte('start_time', new \MongoDate($startDate->getTimestamp()));
                    if ($endDate instanceof \DateTimeImmutable) {
                        $query->whereLt('start_time', new \MongoDate($endDate->getTimestamp()));
                    }

                    if ($calendar != 'all') {
                        $query->where('type', $calendar);
                    }

                    $query->orderBy('start_time');
                }
            );
        }

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

            if ($oHttpRequest->hasGetVar('alt-desc')) {
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
