<?php
namespace tlcal\domain\models\ical;

use Eluceo\iCal\Component\Event as iCalEvent;
use tlcal\domain\LiquidAssets;
use vsc\infrastructure\StringUtils;

class Event extends iCalEvent
{
    protected $alternateDescriptionContentType;
    protected $alternateDescription;

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        parent::setDescription(StringUtils::stripTags($description));
        $this->setAltDescription($description, 'application/html');
    }

    public function setAltDescription ($content, $contentType = 'application/html')
    {
        $this->alternateDescription = $content;
        $this->alternateDescriptionContentType = $contentType;
    }

    public function buildPropertyBag()
    {
        $propBag = parent::buildPropertyBag();

        $propBag->set('X-ALT-DESC;FMTTYPE=' .$this->alternateDescriptionContentType, $this->alternateDescription);

        return $propBag;
    }
}
