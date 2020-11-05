<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table   = 'tblProductCategory';
    protected $guarded = ['ProductCategoryRef'];
    protected $primaryKey = 'ProductCategoryRef';

    public $with = ['product'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'ProductRef');
    }
}
