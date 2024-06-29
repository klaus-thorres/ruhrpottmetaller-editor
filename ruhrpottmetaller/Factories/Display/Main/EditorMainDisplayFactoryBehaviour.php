<?php

namespace ruhrpottmetaller\Factories\Display\Main;

use mysqli;
use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\Main\EditorMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Event;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\IEvent;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmNullInt;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseEventQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    private array $input;
    public function setInput(array $input): void
    {
        $this->input = $input;
    }

    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
    ): AbstractDisplayController {
        $cityQueryModel = DatabaseCityQueryModel::new($connection);
        $bandQueryModel = DatabaseBandQueryModel::new($connection);
        return new EditorMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('main/editor')
            ),
            DatabaseEventQueryModel::new(
                $connection,
                DatabaseGigQueryModel::new($connection, $bandQueryModel),
                DatabaseVenueQueryModel::new($connection, $cityQueryModel)
            ),
            $this->createEvent()
        );
    }

    private function createEvent(): IEvent
    {
        if ($this->input['action'] == 'edit') {
            return $this->loadEvent();
        }

        return $this->createNewEvent();
    }

    private function createNewEvent(): IEvent
    {
        return Festival::new()
            ->setId(RmNullInt::new(null))
            ->setName(RmNullString::new(null))
            ->setDateStart(RmDate::new(substr(
                $this->input['date'],
                0,
                8
            ) . '1'))
            ->setNumberOfDays(RmInt::new(1))
            ->setVenue(NullVenue::new())
            ->setUrl(RmNullString::new(null));
    }

    private function loadEvent(): Event
    {
        if (isset($this->input['number_of_days']) and $this->input['number_of_days'] > 1) {
            $event = Festival::new();
            $event->setNumberOfDays(RmInt::new($this->input['number_of_days']));
            $event->setDateStart(RmDate::new($this->input['date_start'] ?? ''));
        } else {
            $event = Concert::new();
            $event->setDate(RmDate::new($this->input['date_start'] ?? ''));
        }
        $event->setId(RmInt::new($this->input['id'] ?? null));
        $event->setName(RmString::new($this->input['name'] ?? null));
        $event->setVenue(
            isset($this->input['venue_id'])
                ? Venue::new()->setId($this->input['venue_id'])
                : NullVenue::new()
        );
        $event->setUrl(RmString::new($this->input['url'] ?? null));
        return $event;
    }
}