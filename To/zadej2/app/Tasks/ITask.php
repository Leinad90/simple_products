<?php

declare(strict_types=1);

namespace App\Tasks;


/**
 *
 * @author daniel Hejduk
 */
interface ITask {
    
    const TYPE_NUMBER = "number";
    
    public function getTask() : string;
    
    public function getTaskType() : ?string; 
    
    public function getRegexp() : ?string;

    public function rank($givenResult) : float;
    
    public function solved() : ?float;
    
    public function getResult() : mixed;
    
    public function getStartedOn() : \DateTime; 
}
