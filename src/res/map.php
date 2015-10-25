<?php
/** @var $this \vsc\application\sitemaps\SiteMapA */
$this->getCurrentModuleMap()->map('\.ics$', \tlcal\application\controllers\ICalController::class);
$this->getCurrentModuleMap()->map('\.txt$', \tlcal\application\controllers\PlainTextController::class);

$html = $this->getCurrentModuleMap()->map('.*', \vsc\application\controllers\Html5Controller::class);
$html->setMainTemplatePath('templates');
$html->setMainTemplate('main.tpl.php');

// http://calendar/starcraft/2015/november/13/
$this->map('(\w+)/(\d{4})/(\w{3,})/(\d{1,2})/?', \tlcal\application\processors\Calendar::class);
// http://calendar/starcraft/2015/11/13/
$this->map('(\w+)/(\d{4})/(\d{1,2})/(\d{1,2})/?', \tlcal\application\processors\Calendar::class);

// http://calendar/starcraft/2015/november/
$this->map('(\w+)/(\d{4})/(\w{3,})/?', \tlcal\application\processors\Calendar::class);
// http://calendar/starcraft/2015/11/
$this->map('(\w+)/(\d{4})/(\d{1,2})/?', \tlcal\application\processors\Calendar::class);

$this->map('(\w+)/?', \tlcal\application\processors\Calendar::class);
$this->map('.*/?', \tlcal\application\processors\Calendar::class);
