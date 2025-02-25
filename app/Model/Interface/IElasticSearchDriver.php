<?php

declare(strict_types=1);
interface IElasticSearchDriver
{
    /**
     * @param string $id
     * @return array
     */
    public function findById($id);
}

