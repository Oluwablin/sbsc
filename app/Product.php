<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table   = 'tblProduct';
    protected $guarded = ['ProductRef'];
    public $primaryKey = 'ProductRef';

    public $with = ['product_category'];

    public function product_category()
    {
        return $this->hasOne('App\ProductCategory', 'ProductRef');
    }
}
