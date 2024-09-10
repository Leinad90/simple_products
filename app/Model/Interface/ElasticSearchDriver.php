<?php

namespace App\Model\Interface;

interface ElasticSearchDriver
{
    public function findById(string $id): array;
}