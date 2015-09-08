<?php
/** @var $this \vsc\application\sitemaps\SiteMapA */
$this->getCurrentModuleMap()->map('.*', \tlcal\application\controllers\ICalController::class);

$this->map('.*', \tlcal\application\processors\Calendar::class);
