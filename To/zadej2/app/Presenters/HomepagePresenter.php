<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault()
    {
        $this->template->form = $this['form'];
        $this->template->tests= $this->getTests();
    }
    
    public function createComponentForm(): Form {
        $form = new Form($this,'form');
        $form->addText('name','Jméno');
        $form->addRadioList('Test', 'Soutěž', $this->getTestsForCheckbox());
        $form->addSubmit('sent','Zadat');
        $form->onSuccess[]=function($form, $formData) {return $this->processForm($form, $formData);};
        return $form;
    }
    
    private function processForm(Form $form, \Nette\Utils\ArrayHash $formData) {
        $this->redirect($formData->Test,$formData);
    }


    protected function getTestsForCheckbox()
    {
        $return = [];
        foreach ($this->getTests() as $class => $tests) {
            if($class==0) {
                continue;
            }
            foreach ($tests as $link => $description) {
                $return[$link]=$description;
            }
        }
        return $return;
    }
    
    protected function getTests() : array
    {
        return [
            0=>['math'=>'Matematika'],
            1=>['Test:default'=>'Sčítání od jedné do desíti'],
            2=>['Test:second'=>'Sčítání a odčítání od jedné do sta']
        ];
    }
}
