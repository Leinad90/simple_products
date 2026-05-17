<?php

declare(strict_types=1);

namespace App\Model\Database;

/**
 *  @phpstan-import-type Product from \App\Model\ProductDriver
 */
interface IElasticSearchDriver
{
    /**
     * @param string $id
     * @return Product
     */
    public function findById(string $id): array;
}

