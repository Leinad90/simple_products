<?php

declare(strict_types=1);

namespace App\Model\Database;

class ElasticDriver implements IElasticSearchDriver
{

    public function findById($id): array
    {
        return [
          'id'=> $id,
          'driver'=>'elasticsearch',
          'time'=>time(),
        ];
    }
}