<?php
require_once './Models/Stage.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));

$collection = $client->codegen->mazeStages;
$s = new Stage($collection);
$allStages = $s->getAllStages();
$obs_coords = '';
