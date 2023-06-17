<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseConnection;
use ruhrpottmetaller\Factories\{AjaxDisplayFactory, CommandFactory, DisplayFactory};

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

$input = array_merge($_GET, $_POST);

$pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
$databaseConnection = DatabaseConnection::new($pathToDatabaseConfig)
    ->connect()
    ->getConnection();

CommandFactory::new($databaseConnection)
    ->getCommandController($input)
    ->execute();

if (isset($input['ajax'])) {
    $displayFactory = AjaxDisplayFactory::new($databaseConnection);
} else {
    $displayFactory = DisplayFactory::new($databaseConnection);
}

echo $displayFactory->setFactoryBehaviours($input)
    ->getDisplayController($input)
    ->render();
