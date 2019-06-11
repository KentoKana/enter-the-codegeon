<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../Models/User.php';
require_once '../Models/Stage.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));
$userCollection = $client->codegen->users;
$user = new User($userCollection);
$stageCollection = $client->codegen->mazeStages;
$stage = new Stage($stageCollection);

$inputData = json_decode($input);

if (isset($_SESSION['userid'])) {
	$user->getCurrentUser($_SESSION['userid']);
	$stage->getPickedStage($inputData->stageId);

	$user->addStageCompleted($inputData->stageId, $inputData->stars);
	$stage->addUserScore(strval($_SESSION['userid']), $inputData->moves);
}