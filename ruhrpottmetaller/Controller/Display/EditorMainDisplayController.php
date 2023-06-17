<?php

namespace ruhrpottmetaller\Controller\Display;

use ruhrpottmetaller\Data\HighLevel\IEvent;
use ruhrpottmetaller\Model\DatabaseEventQueryModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseEventQueryModel $eventQueryModel;
    private IEvent $event;
    public function __construct(
        View                    $view,
        DatabaseEventQueryModel $eventQueryModel,
        IEvent                  $event
    ) {
        parent::__construct($view);
        $this->eventQueryModel = $eventQueryModel;
        $this->event = $event;
    }

    protected function prepareThisController(): void
    {
        if (
            $this->event->getId()->isNull()
            or !$this->event->getName()->isNull()
            or !$this->event->getVenueId()->isNull()
            or !$this->event->getUrl()->isNull()
        ) {
            $this->view->set('event', $this->event);
        } else {
            $this->view->set(
                'event',
                $this->eventQueryModel->getEventById($this->event->getId())
            );
        }
    }
}