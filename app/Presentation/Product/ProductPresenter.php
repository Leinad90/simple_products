<?php

declare(strict_types=1);

namespace App\Presentation\Product;

use Nette;


class ProductPresenter extends Nette\Application\UI\Presenter
{
    public function actionDetail(string $id): never
    {
        $this->sendJson();
    }
}
