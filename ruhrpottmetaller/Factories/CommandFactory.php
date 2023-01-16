<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractCommandController;
use ruhrpottmetaller\Controller\GeneralCommandController;
use ruhrpottmetaller\Controller\NullCommandController;
use ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\BandCommandModel;

class CommandFactory extends AbstractFactory
{
    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(array $input): AbstractCommandController
    {
        if (isset($input['save']) and $input['save'] == 'band') {
            return GeneralCommandController::new(
                BandCommandModel::new($this->connection),
                $this->getDataObject($input)
            );
        }

        return NullCommandController::new(null, null);
    }

    private function getDataObject(array $input): AbstractHighLevelData
    {
        return Band::new()
            ->setId(RmInt::new($input['id']))
            ->setName(RmString::new($input['name']))
            ->setIsVisible(RmBool::new($input['is_visible']));
    }
}
