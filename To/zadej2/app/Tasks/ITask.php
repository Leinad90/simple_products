<?php

declare(strict_types=1);

namespace App\Tasks;


/**
 *
 * @author daniel Hejduk
 */
abstract class ITask {
    
    use \Nette\SmartObject;
    
    const TYPE_NUMBER = "number";
    
    protected \Nette\Utils\DateTime $startedOn;

    
    public function __construct()
    {
        $this->startedOn = new \Nette\Utils\DateTime();
    }

    abstract public function getTask() : string;
    
    abstract public function getTaskType() : ?string; 
    
    abstract public function getRegexp() : ?string;

    abstract public function rank($givenResult) : float;
    
    abstract public function solved() : ?float;
    
    public function getStep() : ?float 
    {
        return NULL;
    }

    abstract public function getResult() : mixed;
    
    abstract public function getStartedOn() : \DateTime; 
}
