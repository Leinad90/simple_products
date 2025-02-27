<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Database\IElasticSearchDriver;
use App\Model\Database\IMySQLDriver;
use Nette\Caching\Cache;
use Nette\Caching\Storage;

class ProductDriver
{

    public function __construct(
        private readonly Storage $storage,
        private readonly ?IMySQLDriver $mySQLDriver = null,
        private readonly ?IElasticSearchDriver $elasticDriver = null,
    ) {
    }

    /**
     * @return mixed[]
     * @throws InvalidStateException
     */
    public function getById(string $id): array
    {
        $cache = new Cache($this->storage, __CLASS__);
        $this->logIdRead($id);
        return $cache->load(
            ['product' => $id],
            function () use ($id) {
                return $this->findById($id);
            }
        );
    }

    private function logIdRead(string $id): void
    {
        if($this->mySQLDriver) {
            //$this->mySQLDriver->logIdRead($id);
        } elseif ($this->elasticDriver) {
            //$this->elasticDriver->logIdRead($id);
        } else {
            trigger_error("Zvětšeno o jedna");
        }
    }


    /**
     * @return mixed[]
     * @throws InvalidStateException
     */
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