<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;

class Band extends AbstractHighLevelData implements IData
{
    private AbstractRmBool $isVisible;

    public function setIsVisible(AbstractRmBool $isVisible): Band
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getIsVisible(): AbstractRmBool
    {
        return $this->isVisible;
    }
}
