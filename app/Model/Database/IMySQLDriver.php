<?php

declare(strict_types=1);

namespace app\Model\Database;
interface IMySQLDriver
{
    /**
     * @param string $id
     * @return array
     */
    public function findProduct($id);
}
