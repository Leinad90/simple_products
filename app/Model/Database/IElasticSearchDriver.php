<?php

declare(strict_types=1);

namespace App\Model\Database;
interface IElasticSearchDriver
{
    /**
     * @param string $id
     * @return mixed[]
     */
    public function findById(string $id): array;
}

