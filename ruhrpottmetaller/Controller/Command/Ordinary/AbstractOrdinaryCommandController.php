<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Data\IData;

abstract class AbstractOrdinaryCommandController extends AbstractCommandController
{
    protected $data;

    public function __construct(
        $commandModel,
        $data
    ) {
        parent::__construct($commandModel);
        $this->data = $data;
    }

    public static function new(
        $commandModel,
        ?IData $data
    ): AbstractCommandController {
        return new static($commandModel, $data);
    }

    abstract public function execute(): void;
}
