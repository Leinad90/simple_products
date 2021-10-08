<?php

declare(strict_types=1);

namespace App\Tasks;


/**
 *
 * @author daniel Hejduk
 */
class TaskList extends \Nette\Utils\ArrayList
{
    private ?\Nette\Utils\DateTime $solvedOn = null;
    
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
            $return = $actual>$return ? $actual:$return;
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
}
