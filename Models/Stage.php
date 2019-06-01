<?php

class Stage
{
    private $collection;
    private $stageName;
    private $startPosition;
    private $goalPosition;
    private $obstacles;
    private $pickedStage;
    private $allStages;

    // Constructor
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    // Setteres & Getters
    public function setStageName($stageName) {
        return $this->stageName = $stageName;
    } 
    public function getStageName() {
        return $this->stageName;
    }

    public function setStartPosition($startPosition) {
        return $this->startPosition = $startPosition;
    } 
    public function getStartPosition() {
        return $this->startPosition;
    }

    public function setGoalPosition($goalPosition) {
        return $this->goalPosition = $goalPosition;
    } 
    public function getGoalPosition() {
        return $this->startPosition;
    }

    public function setObstacles($obstacles) {
        return $this->obstacles = $obstacles;
    } 
    public function getObstacles() {
        return $this->obstacles;
    }
    
    // Read function
    public function getAllStages(){
        return $this->collection->find();
    }

    public function setPickedStage($pickedStage) {
        $this->pickedStage = $pickedStage;
    }
    public function getPickedStage($pickedStage) {
        $this->pickedStage = $pickedStage;
        $this->collection->findOne(['_id'=>$pickedStage]);
    }

    public function addStage($stageInfo) {
        return $this->collection->insertOne($stageInfo);
    }
}
