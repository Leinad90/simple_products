<?php

namespace App\Model;

class Solvers extends Model
{
    public function getAll() {
        return $this->explorer->table('solvers')->order('points DESC')->order('time DESC')->limit(10)->fetchAll();
    }

    public function insert(array $data): int
    {
        $this->explorer->table('solvers')->insert($data);
        return $this->explorer->getInsertId();
    }
}