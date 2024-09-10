<?php

namespace App\Model\Database;

class ElasticSearchDriver implements \App\Model\Interface\ElasticSearchDriver
{
    public function findById(string $id): array {
        return [
            "id"=>$id,
            "called"=>static::class,
            "defined"=>self::class,
            "time"=>microtime(true)
        ];
    }
}