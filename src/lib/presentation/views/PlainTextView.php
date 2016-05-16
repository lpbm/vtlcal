<?php

namespace tlcal\presentation\views;

class PlainTextView extends ICalView
{
    /**
     * @var string
     */
    protected $sContentType = 'text/plain';
    protected $sFolder = 'txt';

    public function getOutput() {
        return parent::getOutput();
    }
}
