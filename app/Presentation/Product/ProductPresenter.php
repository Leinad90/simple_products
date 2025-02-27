<?php

declare(strict_types=1);

namespace App\Presentation\Product;

use App\Model\ProductDriver;
use Nette;


class ProductPresenter extends Nette\Application\UI\Presenter
{

    public function __construct(
        private readonly ProductDriver $productDriver
    ) {
        parent::__construct();
    }


    public function actionDetail(string $id): never
    {
        $this->sendJson($this->productDriver->getById($id));
    }
}
