<?php

namespace tlcal\presentation\views;

use vsc\presentation\views\CacheableViewA;
use vsc\presentation\views\ExceptionView;

class ICalView extends CacheableViewA
{
    /**
     * @var string
     */
    protected $sContentType = 'text/calendar; charset=utf-8';

    public function getLastModified()
    {
        // TODO: Implement getLastModified() method.
    }

    public function getMTime()
    {
        // TODO: Implement getMTime() method.
    }

    /**
     * @return string
     * @throws ExceptionView
     */
    public function getOutput() {
        return implode("\r\n", $this->getModel()->build());
    }
}
