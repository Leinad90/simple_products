<?php

declare(strict_types=1);

namespace App\Model\Database;

class MySQLDriver implements IMySQLDriver
{

    /**
     * @return scalar[]
     */
    public function findProduct(string $id): array
    {
        return [
            'id'=> $id,
            'driver'=>'MySQL',
            'time'=>time(),
        ];
    }
}