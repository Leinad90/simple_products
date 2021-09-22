<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault()
    {
        
    }
    
    public function createComponentForm(): Form {
        $form = new Form($this);
        $form->addText('name','Jméno');
        $form->addRadioList($name, $label, $items);
        return $form;
    }
}
