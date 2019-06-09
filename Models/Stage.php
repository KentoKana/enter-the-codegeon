<?php

class Stage
{
    private $collection;
    private $stageName;
    private $startPosition;
    private $goalPosition;
    private $obstacles;
    private $pickedStage;

    // Constructor
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    // Setteres & Getters
    public function setStageName($stageName)
    {
        return $this->stageName = $stageName;
    }
    public function getStageName()
    {
        return $this->stageName;
    }

    public function setStartPosition($startPosition)
    {
        return $this->startPosition = $startPosition;
    }
    public function getStartPosition()
    {
        return $this->startPosition;
    }

    public function setGoalPosition($goalPosition)
    {
        return $this->goalPosition = $goalPosition;
    }
    public function getGoalPosition()
    {
        return $this->startPosition;
    }

    public function setObstacles($obstacles)
    {
        return $this->obstacles = $obstacles;
    }
    public function getObstacles()
    {
        return $this->obstacles;
    }

    // Read function
    public function getAllStages()
    {
        return $this->collection->find();
    }

    public function getPickedStage($pickedStage)
    {
        return $this->pickedStage = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectID($pickedStage)]);
    }

    public function getCoord($coordType)
    {
        // Loop through array of coords (can retrieve startPosition and goalPosition)
        // Display coords as strings
        //i.e. x1,y1
        $coord = '';
        for ($i = 0; $i < count($this->pickedStage[$coordType]); $i++) {
            if ($i % 2 !== 0) {
                $coord .= $this->pickedStage[$coordType][$i];
            } else {
                $coord .= $this->pickedStage[$coordType][$i] . ',';
            }
        }
        return $coord;
    }

    public function getObstacleCoords()
    {
        // Get Obstacle Coordinates
        // Loop through array of obstacle coords
        // Display coords as strings
        // Each "cell" is separated by semicolons (;)
        // X and Y separated by commas.
        //i.e. x1,y1;x2,y2;x3,y3;
        $obs_coords = '';
        foreach ($this->pickedStage['obstacles'] as $obstacle) {
            for ($i = 0; $i < count($obstacle); $i++) {
                if ($i % 2 !== 0) {
                    $obs_coords .= $obstacle[$i] . ';';
                } else {
                    $obs_coords .= $obstacle[$i] . ',';
                }
            }
        }
        return $obs_coords;
    }

    public function getSolution()
    {
        // $solutionStr='';
        // foreach($this->pickedStage['solution'] as $move) {
        //     $solutionStr .= "$move;";
        // }
        // return $solutionStr;
        return count($this->pickedStage['solution']);
    }

    public function addStage($stageInfo)
    {
        return $this->collection->insertOne($stageInfo);
    }

    // Add a new user and their high score to this stage
    public function addUserScore($userId, $moves) {
        $userScores = $this->getUserScores();

        if(isset($userScores[$userId])) {
            if($userScores[$userId] > $moves) {
                $userScores[$userId] = $moves;
                $this->collection->updateOne(
                    ['_id' => $this->pickedStage['_id']],
                    ['$set' => [
                        'userScores' => $userScores,
                    ]]
                );
            }
        }
        else {
            $userScores[$userId] = $moves;
            $this->collection->updateOne(
                ['_id' => $this->pickedStage['_id']],
                ['$set' => [
                    'userScores' => $userScores,
                ]]
            );
        }
    }

    // Return an array of users who completed this stage and their scores
    public function getUserScores() {
        $userScores = $this->collection->findOne(
            ['_id' => new MongoDB\BSON\ObjectID($this->pickedStage['_id'])]
        )->userScores;

        return $userScores;
    }
}
