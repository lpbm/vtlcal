<?php
namespace tlcal\application\processors;

use tlcal\domain\access\MongoCalendar;
use tlcal\domain\LiquidAssets;
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;
use vsc\domain\models\ModelA;

class Calendar extends ProcessorA
{
    protected $aLocalVars = [
        'site' => 'teamliquid',
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

        if (LiquidAssets::validType($var)) {
            $calendars[] = $var;
        } else {
            if ($var == 'dota') {
                $calendars[] = LiquidAssets::DOT_ID;
            }
            if ($var == 'cs' || $var == 'cs:go' || $var == 'csgo' || $var == 'counter' || $var == 'counterstrike') {
                $calendars[] = LiquidAssets::CSG_ID;
            }
            if ($var == 'league') {
                $calendars[] = LiquidAssets::LOL_ID;
            }
            if ($var == 'hearthstone') {
                $calendars[] = LiquidAssets::HRT_ID;
            }
            if ($var == 'starcraft') {
                $calendars[] = LiquidAssets::SC2_ID;
            }
            if ($var == 'broodwar' || $var == 'bw') {
                $calendars[] = LiquidAssets::BRW_ID;
            }
            if ($var == 'smash') {
                $calendars[] = LiquidAssets::SMA_ID;
            }
            if ($var == "quake:live") {
                $calendars[] = LiquidAssets::QLV_ID;
            }
            if ($var == "quake:iv") {
                $calendars[] = LiquidAssets::QIV_ID;
            }
            if ($var == "quake:iii") {
                $calendars[] = LiquidAssets::QIII_ID;
            }
            if ($var == "quake:ii") {
                $calendars[] = LiquidAssets::QII_ID;
            }
            if ($var == "quake:world") {
                $calendars[] = LiquidAssets::QW_ID;
            }
            if ($var == "diabotical") {
                $calendars[] = LiquidAssets::DBT_ID;
            }
            if ($var == "overwatch") {
                $calendars[] = LiquidAssets::OVW_ID;
            }
            if ($var == "unreal") {
                $calendars[] = LiquidAssets::UT_ID;
            }
            if ($var == "warsow") {
                $calendars[] = LiquidAssets::WSW_ID;
            }
            if ($var == "xonotic") {
                $calendars[] = LiquidAssets::XNT_ID;
            }
            if ($var == "quake:champions") {
                $calendars[] = LiquidAssets::QCH_ID;
            }
            if ($var == "tl") {
                $calendars[] = LiquidAssets::SC2_ID;
                $calendars[] = LiquidAssets::BRW_ID;
                $calendars[] = LiquidAssets::CSG_ID;
                $calendars[] = LiquidAssets::SMA_ID;
            }
            if ($var == "pfw") {
                $calendars[] = LiquidAssets::QLV_ID;
                $calendars[] = LiquidAssets::QIV_ID;
                $calendars[] = LiquidAssets::QIII_ID;
                $calendars[] = LiquidAssets::QII_ID;
                $calendars[] = LiquidAssets::QW_ID;
                $calendars[] = LiquidAssets::DBT_ID;
                $calendars[] = LiquidAssets::DOOM_ID;
                $calendars[] = LiquidAssets::RFL_ID;
                $calendars[] = LiquidAssets::OVW_ID;
                $calendars[] = LiquidAssets::GG_ID;
                $calendars[] = LiquidAssets::UT_ID;
                $calendars[] = LiquidAssets::WSW_ID;
                $calendars[] = LiquidAssets::DBMB_ID;
                $calendars[] = LiquidAssets::XNT_ID;
                $calendars[] = LiquidAssets::QCH_ID;
                $calendars[] = LiquidAssets::CPMA_ID;
            }
        }
        if (count($calendars) == 0) {
            $calendars[] = LiquidAssets::ALL_ID;
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
        $interval = 'P1Y';

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
