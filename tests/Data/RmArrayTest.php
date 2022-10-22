<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\RmArray;

final class RmArrayTest extends TestCase
{
    private RmArray $Array;

    /**
     * @covers \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(RmArray::class, new RmArray());
    }

    /**
     * @covers \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldImplementTheIDataTypeInterface(): void
    {
        $this->assertInstanceOf(\ruhrpottmetaller\Data\IDataObject::class, new RmArray());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     */
    public function testNewShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(RmArray::class, RmArray::new());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @doesNotPerformAssertions
     */
    public function testAddShouldAcceptVariable(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetShouldReturnSameVariable(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(3));
        $this->assertEquals(3, $this->Array->getCurrent()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testAddShouldBeChainable(): void
    {
        $this->Array = RmArray::new();
        $this->assertEquals(
            3,
            $this->Array->add(RmInt::new(3))->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnTwoVariablesInTheSameOrderAsAdded(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(5))->add(RmInt::new(7));
        $this->assertEquals(5, $this->Array->getCurrent()->get());
        $this->assertEquals(
            7,
            $this->Array->pointAtNext()->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     */
    public function testHasCurrentShouldReturnTrueIfElementIsAvailable(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(5));
        $this->assertTrue($this->Array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testHasCurrentShouldReturnFalseIfCurrentElementIsNotAvailable(): void
    {
        $this->Array = RmArray::new();
        $this->assertFalse($this->Array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetShouldThrowAnErrorIfCurrentElementIsNotAvailable(): void
    {
        $this->expectExceptionMessage('The Array does not contain data at this position.');
        $this->Array = RmArray::new()->getCurrent();
    }
}