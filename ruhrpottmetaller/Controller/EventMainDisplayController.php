<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\QueryEventModel;
use ruhrpottmetaller\View\View;

class EventMainDisplayController extends AbstractDataMainDisplayController
{
    private QueryEventModel $queryEventDatabaseModel;

    public function __construct(
        View $view,
        QueryEventModel $queryEventDatabaseModel
    ) {
        parent::__construct($view);
        $this->queryEventDatabaseModel = $queryEventDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        $events = $this->queryEventDatabaseModel
            ->getEventsByMonth(RmDate::new('2021-11'));

        if (!$events->hasCurrent()) {
            $this->view->setTemplate(RmString::new('event_main_empty'));
            return;
        }

        $this->view->set('events', $events);
    }
}
