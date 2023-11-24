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
            $behaviour = 'EditorAjaxCityVenue';
        } elseif (isset($input['content']) and $input['content'] == 'lineup') {
            $behaviour = 'EditorAjaxLineup';
        } elseif (isset($input['content']) and $input['content'] == 'band_options') {
            $behaviour = 'EditorAjaxBandOptions';
        } else {
            throw new \DomainException('Ajax call not understood');
        }

        $behaviourClass = __NAMESPACE__
            . '\\AjaxFactoryBehaviour\\'
            . $behaviour . 'DisplayFactoryBehaviour';
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
