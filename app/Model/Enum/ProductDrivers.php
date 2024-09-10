<?php

namespace App\Model\Enum;

use App\Model\Interface\ElasticSearchDriver;
use App\Model\Interface\MySQLDriver;

enum ProductDrivers: string
{

    case elastic=ElasticSearchDriver::class;
    case mysql=MySQLDriver::class;
}
