<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;

class QueryEventDatabaseModelMock extends QueryEventDatabaseModel
{
    public function getEventsByMonth(RmString $Month): RmArray
    {
        $DataSet = Festival::new()
                ->setDateStart(RmDate::new('2002-10-02'))
                ->setNumberOfDays(RmInt::new('3'));
        $City = City::new()
            ->setId(RmInt::new('3'))
            ->setName(RmString::new('Essen'));
        $Venue = Venue::new()
            ->setId(RmInt::new('2'))
            ->setName(RmString::new('Don’t Panic'))
            ->setCity($City)
            ->setIsVisible(RmBool::new(1));
        $DataSet
            ->setName(RmString::new('Bierfest'))
            ->setVenue($Venue)
            ->setUrl(RmString::new('www.bierfest.de'))
            ->setIsSoldOut(RmBool::new(0))
            ->setIsCanceled(RmBool::new(0));
        $Array = RmArray::new();
        return $Array->add($DataSet);
    }
}
