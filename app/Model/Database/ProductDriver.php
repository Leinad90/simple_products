<?php

namespace App\Model\Database;

use App\Model\Enum\ProductDrivers;

class ProductDriver
{
    public function __construct(
        protected ProductDrivers $driver,
        protected ?ElasticSearchDriver $elasticSearchDriver = null,
        protected ?MySQLDriver $mySQLDriver = null
    ) {}

    public function getById(string $id): array {
        if($this->driver==ProductDrivers::elastic && $this->elasticSearchDriver) {
            return $this->elasticSearchDriver->findById($id);
        } elseif ($this->driver==ProductDrivers::mysql && $this->mySQLDriver) {
            return $this->mySQLDriver->findProduct($id);
        } else {
            throw new \Exception("Invalid state - driver not known or not set".$this->driver->name);
        }
    }
}