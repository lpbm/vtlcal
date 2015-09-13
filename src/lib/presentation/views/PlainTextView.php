<?php

namespace tlcal\presentation\views;

class PlainTextView extends ICalView
{
    /**
     * @var string
     */
    protected $sContentType = 'text/plain';

    public function getOutput() {
        return parent::getOutput();
    }
}
