<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class AjaxDisplayFactory extends AbstractFactory
{
    private object $displayFactoryBehaviour;
    private RmString $templatePath;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
        $this->templatePath = RmString::new('../templates/');
    }

    public function setFactoryBehaviours(array $input): AjaxDisplayFactory
    {

        if (isset($input['content']) and $input['content'] == 'city_venue') {
            $behaviour = 'CityVenue';
        } elseif (
            isset($input['content'])
            and $input['content'] == 'initial_lineup'
        ) {
            if ($input['event_id'] == '') {
                $behaviour = 'NewLineup';
            } else {
                $behaviour = 'InitialLineup';
            }
        } elseif (
            isset($input['content'])
            and $input['content'] == 'updated_lineup'
        ) {
            $behaviour = 'UpdatedLineup';
        } elseif (
            isset($input['content'])
            and $input['content'] == 'band_options'
        ) {
            $behaviour = 'BandOptions';
        } else {
            throw new \DomainException('Ajax call not understood');
        }

        $behaviourClass = __NAMESPACE__
            . '\\Display\\Ajax\\'
            . 'EditorAjax' . $behaviour . 'DisplayFactoryBehaviour';
        $this->displayFactoryBehaviour = new $behaviourClass();

        return $this;
    }

    public function getDisplayController(array $input): AbstractDisplayController
    {
        return $this->displayFactoryBehaviour->getDisplayController(
            $this->templatePath,
            $this->connection,
            $input
        );
    }
}