<?php

declare(strict_types=1);

namespace App\Tasks;


use InvalidArgumentException;

/**
 *
 * @author daniel Hejduk
 */
class TaskList extends \Nette\Utils\ArrayList
{
    private ?\Nette\Utils\DateTime $solvedOn = null;
    
    private \Nette\Utils\DateTime $startedOn; 

    public function __construct(int $count, ITask $task, array $params=[])
    {
        $str = $task::class;
        bdump($params);
        for($i=0; $i<$count; $i++) {
            $this[] = new $str(...$params);
        }
        $this->startedOn = new \Nette\Utils\DateTime();
    }


    public function offsetSet($index, $value): void
    {
        if( !($value instanceof ITask) ) {
            throw new InvalidArgumentException("Only instance of Itask allowed. ");
        }
        parent::offsetSet($index, $value);
    }
    
    public function offsetGet($index) : ITask
    {
        return parent::offsetGet($index);
    }

    public function getStartedOn() : \Nette\Utils\DateTime {
        $return = \Nette\Utils\DateTime::from('01-01-0001');
        foreach ($this as $task)
        {
            $actual = $task->getStartedOn();
            $return = max($actual, $return);
        }
        return $return;
    }

    public function rank(iterable $result) : float
    {
        $this->solvedOn = new \Nette\Utils\DateTime();
        $return = 0;
        foreach ($this as $i => $task) {
            $return += $task->rank($result[$i]);
        }
        return $return;
    }
    
    public function getSolvedOn() : ?\Nette\Utils\DateTime
    {
        return $this->solvedOn;
    }

    public function getSolvingTime() : float {
        return $this->timeDiffSec($this->getSolvedOn(), $this->getStartedOn());

    }

    private function timeDiffSec(\DateTime $a, \DateTime $b): float
    {
        $interval = $a->diff($b);
        $seconds = 0;

        $days = $interval->format('%r%a');
        $seconds += 24 * 60 * 60 * $days;

        $hours = $interval->format('%H');
        $seconds += 60 * 60 * $hours;

        $minutes = $interval->format('%i');
        $seconds += 60 * $minutes;

        $seconds += $interval->format('%s');

        $usec = $interval->format('%f')/(1000*1000);

        $return = $seconds + $usec;

        return $return;
    }
}
