<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\GeneralCommandController;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{Connection, CityQueryModel, CityCommandModel};

final class GeneralCommandControllerTest extends TestCase
{
    private GeneralCommandController $commandController;
    private CityCommandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->commandModel = CityCommandModel::new(
            $this->connection,
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\CityCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateCityName(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $queryModel = CityQueryModel::new($this->connection);
        $city = City::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Lünen'))
            ->setIsVisible(RmBool::new(true));
        $this->commandController = GeneralCommandController::new(
            $this->commandModel,
            $city
        );
        $this->commandController->execute();
        $this->assertEquals(
            'Lünen',
            $queryModel
                ->getCityById(RmInt::new(1))
                ->getName()
        );

        $query = 'TRUNCATE city';
        $this->connection->query($query);
    }
}
