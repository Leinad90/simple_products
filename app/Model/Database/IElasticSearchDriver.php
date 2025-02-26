<?php

declare(strict_types=1);

namespace app\Model\Database;
interface IElasticSearchDriver
{
    /**
     * @param string $id
     * @return array
     */
    public function findById($id);
}

