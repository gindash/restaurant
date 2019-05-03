<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SalesOrder extends Eloquent
{
    //
    protected $connection = 'mongodb';
    protected $collection = 'sales_order';
}
