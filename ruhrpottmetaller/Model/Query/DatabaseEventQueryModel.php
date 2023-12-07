<?php

namespace ruhrpottmetaller\Model\Query;

use ruhrpottmetaller\Data\HighLevel\{Concert, Event, Festival};
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Date\RmDate, Int\AbstractRmInt, Int\RmInt, String\RmString};
use mysqli;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class DatabaseEventQueryModel extends DatabaseQueryModel
{
    private DatabaseGigQueryModel $gigQueryModel;
    private DatabaseVenueQueryModel $venueQueryModel;

    public function __construct(
        ?mysqli $connection,
        DatabaseGigQueryModel $gigQueryModel,
        DatabaseVenueQueryModel $venueQueryModel
    ) {
        parent::__construct($connection);
        $this->gigQueryModel = $gigQueryModel;
        $this->venueQueryModel = $venueQueryModel;
    }

    public static function new(
        ?mysqli $connection,
        DatabaseGigQueryModel $gigQueryModel,
        DatabaseVenueQueryModel $venueQueryModel
    ): DatabaseEventQueryModel {
        return new static($connection, $gigQueryModel, $venueQueryModel);
    }

    public function getEventsByMonth(RmDate $month): RmArray
    {
        $query = 'SELECT
                id,
                event.name AS name,
                date_start,
                number_of_days,
                venue_id,
                url,
                is_sold_out,
                is_canceled
            FROM event
            WHERE date_start LIKE ? ORDER BY date_start';
        return $this->query(
            $query,
            's',
            [$month->format('Y-m') . '%']
        );
    }

    public function getEventById(AbstractRmInt $id): Event
    {
        $query = 'SELECT
                id,
                event.name AS name,
                date_start,
                number_of_days,
                venue_id,
                url,
                is_sold_out,
                is_canceled
            FROM event
            WHERE id LIKE ?';
        return $this->queryOne(
            $query,
            'i',
            [$id->get()]
        );
    }

    protected function getDataFromResult(stdClass $object): Event
    {
        if ($object->number_of_days > 1) {
            $event = Festival::new()
                ->setDateStart(RmDate::new($object->date_start))
                ->setNumberOfDays(RmInt::new($object->number_of_days));
        } else {
            $event = Concert::new()
                ->setDate(RmDate::new($object->date_start));
        }

        return $this->addGeneralData($event, $object);
    }

    protected function addGeneralData(
        Event $event,
        stdClass $object
    ): Event {
        $venue = $this->venueQueryModel
            ->getVenueById(RmInt::new($object->venue_id));
        return $event
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->addGigs($this->gigQueryModel->getGigsByEventId(RmInt::new($object->id)))
            ->setVenue($venue)
            ->setUrl(RmString::new($object->url))
            ->setIsSoldOut(RmBool::new($object->is_sold_out))
            ->setIsCanceled(RmBool::new($object->is_canceled));
    }
}
