<?php

declare(strict_types=1);

namespace App\Model\Database;
interface IMySQLDriver
{
    /**
     * @return mixed[]
     */
    public function findProduct(string $id): array;
}
