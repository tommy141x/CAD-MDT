<?php
include 'config.php';

//DATABASE NAME FOR THIS COMMUNITY
$dbNAME = $databaseName;































require 'Medoo.php';
use Medoo\Medoo;

$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $dbNAME,
    'server' => $dbHOST,
    'username' => $dbUSER,
    'password' => $dbPASS
]);
