<?php

declare(strict_types=1);

namespace App\Model\Database;

class MySQLDriver implements IMySQLDriver
{

    public function findProduct($id): array
    {
        return [
            'id'=> $id,
            'driver'=>'MySQL',
            'time'=>time(),
        ];
    }
}