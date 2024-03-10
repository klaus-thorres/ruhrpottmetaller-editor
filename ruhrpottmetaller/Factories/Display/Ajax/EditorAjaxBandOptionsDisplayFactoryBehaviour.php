<?php

namespace ruhrpottmetaller\Factories\Display\Ajax;

use mysqli;
use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\Ajax\EditorAjaxBandOptionsDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxBandOptionsDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection,
        array $input
    ): AbstractDisplayController {
        return new EditorAjaxBandOptionsDisplayController(
            View::new(
                $templatePath,
                RmString::new('ajax/editor_band_options')
            ),
            DatabaseBandQueryModel::new($connection),
            RmString::new($input['band_first_char']),
            RmInt::new($input['band_id'])
        );
    }
}
