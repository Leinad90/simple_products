<?php

namespace App\Model;

use App\Model\Database\ProductDriver;
use Nette\Caching\Cache;
use Nette\Caching\Storage;

class ProductsModel
{

    private Cache $Cache;
    public function __construct(
        Storage                        $CacheStorage,
        private readonly ProductDriver $driver,
    ) {
        $this->Cache = new Cache($CacheStorage, self::class);
    }

    public function getById(string $id): array {
        $key = [__FUNCTION__, func_get_args()];
        $this->intercaseCount($id);
        return $this->Cache->load($key, function () use ($id) {
            $this->driver->getById($id);
        });
    }

    private function intercaseCount(string $id): void {
        //@todo
    }

}