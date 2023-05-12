<?php

namespace App\Component;

use App\Model\Solvers;
use Nette\Application\UI\Control;

class BestOfTable extends Control
{

    public function __construct(
        protected readonly Solvers $solvers
    ) {
        //parent::__construct($parent, $name);
    }

    public function render()
    {
        $this->template->solvers=$this->solvers->getAll();
        $this->template->render(__DIR__.'/templates/bestOfTable.latte');
    }

}