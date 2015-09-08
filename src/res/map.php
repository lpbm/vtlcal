<?php
/** @var $this \vsc\application\sitemaps\SiteMapA */
$this->getCurrentModuleMap()->map('.*', \tlcal\application\controllers\ICalController::class);
$this->getCurrentModuleMap()->map('\.ics$', \tlcal\application\controllers\ICalController::class);


// http://calendar/2015/november/13/
$this->map('(\d{4})/(\w)+/(\d{2})/?', \tlcal\application\processors\CalendarDay::class);
// http://calendar/2015/11/13/
$this->map('(\d{4})/(\d{2})/(\d{2})/?', \tlcal\application\processors\CalendarDay::class);

// http://calendar/2015/november/
$this->map('(\d{4})/(\w)+/?', \tlcal\application\processors\CalendarMonth::class);
// http://calendar/2015/11/
$this->map('(\d{4})/(\d{2})/?', \tlcal\application\processors\CalendarMonth::class);

$this->map('.*/?', \tlcal\application\processors\Calendar::class);
