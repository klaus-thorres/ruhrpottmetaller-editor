<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Command;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Command\GeneralCommandController;
use ruhrpottmetaller\Data\HighLevel\{Band, City, Venue};
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{DatabaseCityCommandModel, DatabaseCityQueryModel};
use ruhrpottmetaller\Model\{DatabaseBandCommandModel, DatabaseBandQueryModel};
use ruhrpottmetaller\Model\{DatabaseVenueCommandModel, DatabaseVenueQueryModel};
use ruhrpottmetaller\Model\DatabaseConnection;

final class GeneralCommandControllerTest extends TestCase
{
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\DatabaseCityCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateCityName(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $commandModel = DatabaseCityCommandModel::new($this->connection);
        $queryModel = DatabaseCityQueryModel::new($this->connection);
        $city = City::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Lünen'))
            ->setIsVisible(RmBool::new(true));
        $this->commandController = GeneralCommandController::new(
            $commandModel,
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

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\DatabaseBandCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateBandName(): void
    {
        $query = 'INSERT INTO band SET name = "Mad Butcher"';
        $this->connection->query($query);
        $queryModel = DatabaseBandQueryModel::new($this->connection);
        $commandModel = DatabaseBandCommandModel::new($this->connection);
        $data = Band::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Kreator'))
            ->setIsVisible(RmBool::new(true));
        $commandController = GeneralCommandController::new(
            $commandModel,
            $data
        );
        $commandController->execute();
        $this->assertEquals(
            'Kreator',
            $queryModel
                ->getBandById(RmInt::new(1))
                ->getName()
        );

        $query = 'TRUNCATE band';
        $this->connection->query($query);
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\DatabaseVenueCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseCityCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateVenueName(): void
    {
        $query = 'INSERT INTO venue SET name = "Parkhaus", city_id = 1';
        $this->connection->query($query);
        $query = 'INSERT INTO city SET name = "Duisburg"';
        $this->connection->query($query);
        $queryModel = DatabaseVenueQueryModel::new(
            $this->connection,
            DatabaseCityQueryModel::new($this->connection)
        );
        $commandModel = DatabaseVenueCommandModel::new($this->connection);
        $city = City::new()->setId(RmInt::new(1));
        $data = Venue::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Kultopia'))
            ->setCity($city)
            ->setUrlDefault(RmString::new(''))
            ->setIsVisible(RmBool::new(true));
        $commandController = GeneralCommandController::new(
            $commandModel,
            $data
        );
        $commandController->execute();
        $this->assertEquals(
            'Kultopia',
            $queryModel
                ->getVenueById(RmInt::new(1))
                ->getName()
        );

        $query = 'TRUNCATE band';
        $this->connection->query($query);
    }
}