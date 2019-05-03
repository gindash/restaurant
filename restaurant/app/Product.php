<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    //
    protected $connection = 'mongodb';
    protected $collection = 'products';
}
