<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;

class Festival extends AbstractEvent
{
    protected AbstractRmInt $NumberOfDays;
    protected RmDate $DateStart;


    public function setDateStart(RmDate $DateStart): Festival
    {
        $this->DateStart = $DateStart;
        return $this;
    }

    public function getDateStart(): RmDate
    {
        return $this->DateStart;
    }

    public function setNumberOfDays(AbstractRmInt $NumberOfDays): Festival
    {
        $this->NumberOfDays = $NumberOfDays;
        return $this;
    }

    public function getNumberOfDays(): AbstractRmInt
    {
        return $this->NumberOfDays;
    }
}
