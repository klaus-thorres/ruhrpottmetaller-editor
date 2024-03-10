<?php

namespace ruhrpottmetaller\Controller\Display\Main;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayController extends AbstractDataMainDisplayController
{
    private DatabaseCityQueryModel $cityQueryModel;

    public function __construct(
        View $view,
        DatabaseCityQueryModel $queryCityDatabaseModel
    ) {
        parent::__construct($view);
        $this->cityQueryModel = $queryCityDatabaseModel;
    }

    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();

        if ($this->filterByParameter->get() == '%') {
            $data = $this->cityQueryModel->getCitiesWithSpecialChar();
        } elseif ($this->filterByParameter->isEmpty()) {
            $data = $this->cityQueryModel->getCities();
        } else {
            $data = $this->cityQueryModel->getCitiesByFirstChar($this->filterByParameter);
        }

        if (!$data->hasCurrent()) {
            $this->view->setTemplate(RmString::new('main/city_empty'));
            return;
        }

        $this->view->set('cities', $data);
    }
}
