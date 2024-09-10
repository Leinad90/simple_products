<?php

namespace App\Model\Interface;

interface MySQLDriver
{
    public function findProduct(string $id): array;
}