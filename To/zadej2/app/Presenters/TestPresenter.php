<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class TestPresenter extends Nette\Application\UI\Presenter
{
        
    public function __construct()
    {
        parent::__construct();
    }


    public function renderDefault(array $formData)
    {
        $session = $this->getSession('TaskList');
        if(empty($session->TaskList) || count($session->TaskList)==0 ) {
            $session->TaskList = new \App\Tasks\TaskList();
            for($i=0; $i<5; $i++) {
                $session->TaskList[] = new \App\Tasks\MathTask(); 
            }
            $session->name = $formData[name];
        }
    }


	protected function createComponentForm(): Form
	{
        $session = $this->getSession('TaskList');
        $form = new Form();
        $form->addProtection();
        $allowSend = $showResult = false;
        /**
         * @var \App\Tasks\TaskList
         */
        $taskList = $session->TaskList;
        foreach ($taskList as $id =>  $Task) {     
            $elem = $form->addText((string)$id, $Task->getTask());
            if($Task->solved()!==null) {
                $showResult = true;
                $elem->disabled = true;
                $elem->caption .= ' = '.$Task->getResult();
                $elem->addError($Task->solved().' '.'bodů'); 
            } else {
                $allowSend = true;
            }
            if( ($taskType = $Task->getTaskType()) ) {
                $elem->setHtmlType($taskType);
            }
            if( ($regexp = $Task->getRegexp()) ) {
                $elem->addRule(validator: $form::PATTERN, errorMessage: "Výsledek musí odpovídat masce %s", arg: $regexp);
            }
        }
        if($allowSend) {
            $form->addText('started_on','Zadáno')->setDisabled()->setDefaultValue($session->TaskList->getStartedOn()->format('H:i:s'))->setHtmlId('started_on'); 
            $form->addText('actual_time','Aktuální čas')->setDefaultValue(date('H:I:S'))->setDisabled()->setHtmlId('actual_time');
            $form->addSubmit("sent", "Vyhodnotit");
        }
        if($showResult) {
            $form->addText('total','Celkem: ')->setDisabled()->addError($session->rank.' '.'bodů');
            $form->addText('time','Čas: ')->setDisabled()->setDefaultValue($taskList->getStartedOn()->format('H:i:s').' - '.$taskList->getSolvedOn()->format('H:i:s'))->addError($this->timeDiffSec($taskList->getStartedOn(), $taskList->getSolvedOn()).' '.'sekund'); 
        }
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}
    
   public function formSucceeded(Form $form, \Nette\Utils\ArrayHash $formData): void
	{
        $session = $this->getSession('TaskList');
        $session->rank = $session->TaskList->rank($formData);
        $this->redirect('rank',$formData);
	}
    
    public function renderRank(\ArrayAccess|array $formData)
    {
        $session = $this->getSession('TaskList');
        $this['form']->setDefaults($formData);
    }

    private function timeDiffSec(\DateTime $a, \DateTime $b): int
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
        
        return $seconds;
    }

}
