<?php

namespace App\Model;

use Nette\Database\Explorer;

class Model
{
    public function __construct(
        protected readonly Explorer $explorer
    ) {
    }

}