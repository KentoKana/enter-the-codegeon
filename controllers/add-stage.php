<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../Models/Stage.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));
$collection = $client->codegen->mazeStages;
$stage = new Stage($collection);

$inputData = json_decode($input);

$inputData->userScores = new StdClass;

$stage->addStage($inputData);

echo 'Stage Added';