<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../Models/Stage.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));
$collection = $client->codegen->mazeStages;
$stage = new Stage($collection);

$inputData = json_decode($input);

$stageInfo = $stage->getPickedStage($inputData->stageId);

$startPos = $stageInfo->startPosition;
$goalPos = $stageInfo->goalPosition;
$obstacles = $stageInfo->obstacles;

echo json_encode(array(
	'startPosition' => $startPos,
	'goalPosition' => $goalPos,
	'obstacles' => $obstacles
));