<?php
namespace tlcal\domain\models\ical;

use Eluceo\iCal\Component\Calendar as iCalCalendar;
use Eluceo\iCal\Component\Event;
use Eluceo\iCal\Component\Timezone;
use tlcal\domain\LiquidAssets;
use vsc\domain\models\ModelA;

class Calendar extends ModelA
{
    /**
     * @var iCalCalendar
     */
    protected $ical;

    public function __construct(array $types = []) {
        $this->ical = new iCalCalendar('TL-CAL/v0.1.0');
        $this->ical->setTimezone(new Timezone('UTC'));
        $this->ical->setPublishedTTL('P1H');
        if (count($types)) {
            $calendarNames= [];
            $calendarFullNames = [];
            foreach ($types as $type) {
                $calendarNames[] = LiquidAssets::getLabel($type);
                $calendarFullNames[] = LiquidAssets::getFullLabel($type);
            }
            $this->ical->setName(implode($calendarNames, ', '));
            $this->ical->setDescription('Calendar for: ' . implode($calendarFullNames, ', '));
        }
    }

    /**
     * @param Event $event
     */
    public function addEvent($event) {
        $this->ical->addComponent($event);
    }

    public function build() {
        return $this->ical->build();
    }
}
