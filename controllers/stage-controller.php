<?php
require_once './Models/Stage.php';

$input = file_get_contents("php://input");

$client = new MongoDB\Client(env('MONGO_URI'));

$collection = $client->codegen->mazeStages;
$s = new Stage($collection);
$allStages = $s->getAllStages();
$obs_coords = '';


if (isset($_POST['stageId'])) {
    // Loop through array of obstacle coords
    // Display coords as strings
    // Each "cell" is separated by semicolons (;)
    // X and Y separated by commas.
    //i.e. x1,y1;x2,y2;x3,y3;
    $pickedStage = $s->getPickedStage($_POST['stageId']);
    foreach ($pickedStage['obstacles'] as $obstacle) {
        for ($i = 0; $i < count($obstacle); $i++) {
            if ($i % 2 !== 0) {
                $obs_coords .= $obstacle[$i] . ';';
            } else {
                $obs_coords .= $obstacle[$i] . ',';
            }
        }
    }
}
