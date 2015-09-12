<?php
namespace tlcal\domain\models\ical;

use Eluceo\iCal\Component\Calendar as iCalCalendar;
use Eluceo\iCal\Component\Event;
use vsc\domain\models\ModelA;

class Calendar extends ModelA
{
    /**
     * @var iCalCalendar
     */
    protected $ical;

    public function __construct() {
        $this->ical = new iCalCalendar(uniqid('TL-CAL/'));
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
