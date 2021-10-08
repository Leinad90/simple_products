<?php

declare(strict_types=1);


namespace App\Tasks;

/**
 * Description of MathTask
 *
 * @author Daniel Hejduk <daniel.hejduk at gmail.com>
 */
class MathTask implements ITask {
    
    private ?float $solved = null;
    
    private float $a, $b;
    protected $operator; 
    
    private \Nette\Utils\DateTime $startedOn; 
    
    private ?\Nette\Utils\DateTime $solvedOn = null; 

    public function __construct(float $min=0, float $max=INF, int $difucity=2) {
        $this->a = $this->randomNumber($min, $max);    
        $this->b = $this->randomNumber($min, $max);
        $this->operator = $this->createOperator($difucity);
        $this->startedOn = new \Nette\Utils\DateTime();
    }
    
    public function randomNumber(float $min, float $max, float $step=2): float
    {
        $random = random_int(0, PHP_INT_MAX)/PHP_INT_MAX;
        $diff = $max - $min;
        return $this->round($random*$diff + $min, $step);
    }
    
    protected function round(float $value, float $step=1): float
    {
        $diff=fmod($value,$step);
        $return = $value-$diff;
        if($diff>$step/2) {
             $return += $step;
        }
        return $return;
    }


    protected function createOperator(int $difucity = 2):string
    {
        $operators = '+-*/^';
        $index = random_int(0, $difucity);
        return $operators[$index];
    }

    public function getTask() : string 
    {
        return $this->a . ' '.$this->operator.' '. $this->b;
    }
    
    public function getTaskType() : string 
    {
        return $this::TYPE_NUMBER;
    }
    
    public function getRegexp() : string
    {
        return "(\+|\-){0,1}[0-9| ]+((\.|,)[0-9| ]+){0,1}";
    }
    
    public function rank($givenResult) : float 
    {
        $this->solvedOn = new \Nette\Utils\DateTime();
        $correct= $this->getResult();
        $givenResult = (float)$givenResult;
        if(\Nette\Utils\Floats::areEqual($correct, $givenResult))  {
            return $this->solved = 1;
        }
        if($this->signum($givenResult) != $this->signum($correct) ) {
            return $this->solved = 0;
        }
        return $this->solved = min($givenResult/$correct, $correct/$givenResult);
    }
    
    private function signum(float $a) : int
    {
        return $a>0 ? 1 : ($a<0 ? -1 : 0);
    }
    
    public function solved() : ?float
    {
        return $this->solved;
    }
    
    public function getResult() : float
    {
        $stringCalc = new \ChrisKonnertz\StringCalc\StringCalc();
        return $stringCalc->calculate($this->getTask());
    }
    
    public function getStartedOn() : \Nette\Utils\DateTime
    {
        return $this->startedOn;
    }
    
    public function getSolvedOn() : \Nette\Utils\DateTime
    {
        return $this->solvedOn;
    }
}
