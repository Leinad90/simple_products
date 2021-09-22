<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Nette\Application\UI\Form; 
namespace App\Forms; 

class TaskForm extends \Nette\Application\UI\Control
{
    use \Nette\SmartObject; 
        
    public function __construct(protected \App\Tasks\ITask $Itask)
    {
        
    }
    
    public function getTask($onSuccess) : Form
    {
        $return = new Form();
        
        
        $elem = $return->addText("1", $this->Itask->getTask());
        if( ($taskType = $this->Itask->getTaskType()) ) {
            $elem->setHtmlType($taskType);
        }
        
        $return ->addSubmit("sent", "Vyhodnotit");
        return $return;
    }
}