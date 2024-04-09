<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\EventQueryModel;

class EventQueryDatabaseModelMockEmpty extends EventQueryModel
{
    public function getEventsByMonth(RmDate $month): RmArray
    {
        return RmArray::new();
    }
}
