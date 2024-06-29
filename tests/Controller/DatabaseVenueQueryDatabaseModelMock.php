<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;

class DatabaseVenueQueryDatabaseModelMock extends DatabaseVenueQueryModel
{
    public function getVenues(): RmArray
    {
        $city = City::new()
            ->setId(RmInt::new('3'))
            ->setName(RmString::new('Essen'))
            ->setIsVisible(RmBool::new(true));
        $venue  = Venue::new()
            ->setId(RmInt::new('2'))
            ->setName(RmString::new('Turock'))
            ->setCity($city)
            ->setIsVisible(RmBool::new(true));
        $Array = RmArray::new();
        return $Array->add($venue);
    }

    public function getVenuesByCityId(?AbstractRmInt $cityId): RmArray
    {
        $city = City::new()
            ->setId(RmInt::new('3'))
            ->setName(RmString::new('Dortmund'))
            ->setIsVisible(RmBool::new(true));
        $venue  = Venue::new()
            ->setId(RmInt::new('2'))
            ->setName(RmString::new('JunkYard'))
            ->setCity($city)
            ->setIsVisible(RmBool::new(true));
        $Array = RmArray::new();
        return $Array->add($venue);
    }
}