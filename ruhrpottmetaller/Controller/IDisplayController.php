<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\View\View;

interface IDisplayController
{
    public static function new(View $View);
    public function render(): AbstractRmString;
    public function addSubController(
        string $subControllerId,
        AbstractDisplayController $DisplayController
    );
}