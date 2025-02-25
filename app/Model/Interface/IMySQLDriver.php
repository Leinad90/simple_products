<?php

declare(strict_types=1);

interface IMySQLDriver
{
    /**
     * @param string $id
     * @return array
     */
    public function findProduct($id);
}
