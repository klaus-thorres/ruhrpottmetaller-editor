<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

final class CityTest extends TestCase
{
    private \ruhrpottmetaller\Data\HighLevel\City $DataSet;

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\City
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldSetNameAndGetSameNameBack(): void
    {
        $this->DataSet = City::new();
        $this->DataSet->setName(RmString::new('Essen'));
        $this->assertEquals(
            'Essen',
            $this->DataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\City
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldSetIdAndGetSameIdBack(): void
    {
        $this->DataSet = City::new();
        $this->DataSet->setId(RmInt::new(123));
        $this->assertEquals(
            '123',
            $this->DataSet->getId()->get()
        );
    }
}