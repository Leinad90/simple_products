<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Database\ElasticDriver;
use App\Model\Database\MySQLDriver;
use Nette\Caching\Cache;
use Nette\Caching\Storage;

class ProductDriver
{

    public function __construct(
        private readonly ?MySQLDriver $mySQLDriver = null,
        private readonly ?ElasticDriver $elasticDriver = null,
        private readonly Storage $storage
    ) {

    }
    public function getById(string $id): array
    {
        $cache = new Cache($this->storage, __CLASS__);
        return $cache->load(
            ['product' => $id],
            function () use ($id) {
                return $this->findById($id);
            }
        );
    }

    private function findById(string $id): array
    {
        if($this->mySQLDriver) {
            return $this->mySQLDriver->findProduct($id);
        } elseif ($this->elasticDriver) {
            return $this->elasticDriver->findById($id);
        }
        throw new InvalidStateException('No driver has been injected.');
    }
}

class InvalidStateException extends \RuntimeException
{

}