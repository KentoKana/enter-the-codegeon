<?php
session_start();
$client = new MongoDB\Client(env('MONGO_URI'));
require_once './Models/Stage.php';

$collection = $client->codegen->mazeStages;
$s = new Stage($collection);
$allStages = $s->getAllStages();

?>