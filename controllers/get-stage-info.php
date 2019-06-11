<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../Models/Stage.php';
require_once '../Models/User.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));
$userCollection = $client->codegen->users;
$user = new User($userCollection);
$stageCollection = $client->codegen->mazeStages;
$stage = new Stage($stageCollection);

$inputData = json_decode($input);

$stageInfo = $stage->getPickedStage($inputData->stageId);

$startPos = $stageInfo->startPosition;
$goalPos = $stageInfo->goalPosition;
$obstacles = $stageInfo->obstacles;
$stars = 0;

if (isset($_SESSION['userid'])) {
	$user->getCurrentUser($_SESSION['userid']);
	$completedStages = $user->getCompletedStages();

	if(isset($completedStages[$inputData->stageId])) {
		$stars = $completedStages[$inputData->stageId];
	}
}

echo json_encode(array(
	'startPosition' => $startPos,
	'goalPosition' => $goalPos,
	'obstacles' => $obstacles,
	'stars' => $stars
));