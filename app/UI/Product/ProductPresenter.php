<?php

declare(strict_types=1);

namespace App\UI\Product;

use App\Model\ProductsModel;
use Nette;


final class ProductPresenter extends Nette\Application\UI\Presenter
{

    #[Nette\DI\Attributes\Inject]
    public ProductsModel $Products;

    public function actionDetail(string $id): never
    {
        $data = $this->Products->getById($id);
        $this->sendJson($data);
    }
}
