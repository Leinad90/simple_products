<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Database\FileSystemDriver;
use App\Model\Database\IElasticSearchDriver;
use App\Model\Database\IMySQLDriver;
use Nette\Caching\Cache;
use Nette\Caching\Storage;

/**
 * @phpstan-type Product array{id: string, driver: string, time: int}
 */

class ProductDriver
{

    public function __construct(
        private readonly Storage $storage,
        private readonly FileSystemDriver $fileSystemDriver,
        private readonly ?IMySQLDriver $mySQLDriver = null,
        private readonly ?IElasticSearchDriver $elasticDriver = null,
    ) {
    }

    /**
     * @return Product
     * @throws InvalidStateException
     */
    public function getById(string $id): array
    {
        $cache = new Cache($this->storage, __CLASS__);
        $this->logIdRead($id);
        return $cache->load( /** @phpstan-ignore return.type (cache returning ok) */
            ['product' => $id],
            function () use ($id) {
                return $this->findById($id);
            }
        );
    }

    private function logIdRead(string $id): void
    {
        $this->fileSystemDriver->incrementReadCounter($id);
    }


    /**
     * @return Product
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