<?php
namespace tlcal\application\processors;

use tlcal\domain\access\mongo\MongoCalendar;
use tlcal\domain\LiquidAssets;
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
        $calendars = [];

        if ($var == 'dota') {
            $calendars[] = 'dot';
        }
        if ($var == 'cs'  || $var == 'cs:go' || $var == 'csgo' || $var == 'counter' || $var == 'counterstrike') {
            $calendars[] = 'csg';
        }
        if ($var == 'league' || $var == 'lol') {
            $calendars[] = 'lol';
        }
        if ($var == 'hearthstone') {
            $calendars[] = 'hrt';
        }
        if ($var == 'starcraft' || $var == 'sc2') {
            $calendars[] = 'sc2';
        }
        if ($var == 'broodwar' || $var == 'bw') {
            $calendars[] = 'brw';
        }
        if ($var == 'smash') {
            $calendars[] = 'sms';
        }
        if ($var == "pfw") {
            $calendars[] = 'pfw';
        }
        if ($var == "qlv") {
            $calendars[] = 'qlv';
        }
        if ($var == "qiv") {
            $calendars[] = 'qiv';
        }
        if ($var == "qiii") {
            $calendars[] = 'qiii';
        }
        if ($var == "qii") {
            $calendars[] = 'qii';
        }
        if ($var == "qw") {
            $calendars[] = 'qw';
        }
        if ($var == "dbt") {
            $calendars[] = 'dbt';
        }
        if ($var == "doom") {
            $calendars[] = 'doom';
        }
        if ($var == "rfl") {
            $calendars[] = 'rfl';
        }
        if ($var == "ovw") {
            $calendars[] = 'ovw';
        }
        if ($var == "gg") {
            $calendars[] = 'gg';
        }
        if ($var == "ut") {
            $calendars[] = 'ut';
        }
        if ($var == "wsw") {
            $calendars[] = 'wsw';
        }
        if ($var == "dbmb") {
            $calendars[] = 'dbmb';
        }
        if ($var == "xnt") {
            $calendars[] = 'xnt';
        }
        if ($var == "qch") {
            $calendars[] = 'qch';
        }
        if ($var == "cpma") {
            $calendars[] = 'cpma';
        }
        if (count($calendars) == 0) {
            $calendars[] = 'all';
        }
        return $calendars;
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
        $calendars = $this->getTypeFromUrl($this->getVar('calendar'));
        $model = (new MongoCalendar())
            ->loadCalendars($calendars, $this->getDates(), $oHttpRequest->hasGetVar('alt-desc'));

        return $model;
    }
}
