<?php
require_once './Models/Stage.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));

$collection = $client->codegen->mazeStages;
$s = new Stage($collection);
$allStages = $s->getAllStages();
$obs_coords = '';
$start_coord='';


if (isset($_POST['stageId'])) {
    $pickedStage = $s->getPickedStage($_POST['stageId']);

    $_SESSION['stageName'] = $pickedStage['stageName'];
    //Set stageId session.
    $_SESSION['stageId'] = $pickedStage['_id'];

    // Set sessions for Coordinates
    $_SESSION['startCoord'] = $s->getCoord('startPosition');
    $_SESSION['goalCoord'] = $s->getCoord('goalPosition');
    $_SESSION['obsCoords'] = $s->getObstacleCoords();
}
