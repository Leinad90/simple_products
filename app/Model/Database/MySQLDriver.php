<?php

namespace App\Model\Database;

class MySQLDriver implements \App\Model\Interface\MySQLDriver
{
    public function findProduct(string $id): array {
        return [
            "id"=>$id,
            "called"=>static::class,
            "defined"=>self::class,
            "time"=>microtime(true)
        ];
    }
}