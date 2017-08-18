<?php
namespace tlcal\application\processors;

use tlcal\domain\LiquidAssets;
use tlcal\domain\models\ical\Calendar as CalendarModel;
use tlcal\domain\models\ical\Event;
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\domain\models\ModelA;
use MongoDB;

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
        if ($var == "pfw") {
            return 'pfw';
        }
        if ($var == "qlv") {
            return 'qlv';
        }
        if ($var == "qiv") {
            return 'qiv';
        }
        if ($var == "qiii") {
            return 'qiii';
        }
        if ($var == "qii") {
            return 'qii';
        }
        if ($var == "qw") {
            return 'qw';
        }
        if ($var == "dbt") {
            return 'dbt';
        }
        if ($var == "doom") {
            return 'doom';
        }
        if ($var == "rfl") {
            return 'rfl';
        }
        if ($var == "ovw") {
            return 'ovw';
        }
        if ($var == "gg") {
            return 'gg';
        }
        if ($var == "ut") {
            return 'ut';
        }
        if ($var == "wsw") {
            return 'wsw';
        }
        if ($var == "dbmb") {
            return 'dbmb';
        }
        if ($var == "xnt") {
            return 'xnt';
        }
        if ($var == "qch") {
            return 'qch';
        }
        if ($var == "cpma") {
            return 'cpma';
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

        if (is_null($day)) {
            $interval = 'P1M';
            $day = '01';
        }
        if (is_null($month)) {
            $interval = 'P1Y';
            $month = '01';
        }
        if (is_null($year)) {
            $interval = 'P1Y';
            $year = (new \DateTime('now'))->format('Y');
        }
        $dateString = '%s-%s-%s 00:00:00.00000';
        $format = 'Y-m-d H:i:s.u';
        if (!is_numeric($month)) {
            if (strlen($month) == 3) {
                $format = 'Y-M-d 00:00:00.00000';
            } else {
                $format = 'Y-F-d 00:00:00.00000';
            }

        }
        $date = sprintf($dateString, $year, ucfirst($month), $day);
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
        $connection = new MongoDB\Driver\Manager('mongodb://127.0.0.1');

        $calendar = $this->getTypeFromUrl($this->getVar('calendar'));
        $collection = new MongoDB\Collection($connection, 'tlcalendar', 'events');
        list($startDate, $endDate) = $this->getDates();
        $query = [];

        if ($startDate instanceof \DateTimeImmutable) {
            $query['end_time'] = ['$gte' => new MongoDB\BSON\UTCDateTime($startDate->getTimestamp())];
        }
        if ($endDate instanceof \DateTimeImmutable) {
            $query['start_time'] = ['$lt' => new MongoDB\BSON\UTCDateTime($endDate->getTimestamp())];
            $query = [
                '$and' => [
                        [
                            'end_time' => ['$gte' => new MongoDB\BSON\UTCDateTime($startDate->getTimestamp())],
                        ],
                        //[
                        //    'start_time' => ['$lt' => new MongoDB\BSON\UTCDateTime($endDate->getTimestamp())]
                        //]
                    ]
            ];
            unset($query['end_time']);
        }
        if ($calendar != 'all') {
            $query['$and'][] = ['type' => $calendar];
        }

        //var_dump(json_encode($query));die;
        $cursor = $collection->find($query, ['sort' => ['start_time' => -1]]);

        $model = new CalendarModel($calendar);
        foreach($cursor as $event) {
            $ev = new Event(md5($event->type . ':' . $event->tl_id));
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

            if ($oHttpRequest->hasGetVar('alt-desc')) {
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
                $html = $doc->saveHTML($section);
                $ev->setAltDescription($html, 'text/html');
            }

            if ($calendar == 'all') {
                $ev->setSummary('[' . strtoupper($event->type) . '] ' . $event->category . ': ' . $event->stage);
            } else {
                $ev->setSummary($event->category . ': ' . $event->stage);
            }
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
