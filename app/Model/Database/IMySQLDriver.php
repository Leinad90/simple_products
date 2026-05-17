<?php

declare(strict_types=1);

namespace App\Model\Database;

/**
 *  @phpstan-import-type Product from \App\Model\ProductDriver
 */
interface IMySQLDriver
{
    /**
     * @return Product
     */
    public function findProduct(string $id): array;
}
