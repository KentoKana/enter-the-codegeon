<?php
session_start();

$input = file_get_contents( "php://input" );

if($input === '') {
	require_once './Models/Stage.php';

	$client = new MongoDB\Client(env('MONGO_URI'));

	$collection = $client->codegen->mazeStages;
	$s = new Stage($collection);
	$allStages = $s->getAllStages();
}
else {
	require_once '../vendor/autoload.php';
	require_once '../Models/Stage.php';

	$client = new MongoDB\Client(env('MONGO_URI'));
	$collection = $client->codegen->mazeStages;
	$stage = new Stage($collection);

	$inputData = json_decode($input);

	$stage->addStage($inputData);

	echo 'Stage Added';
}
