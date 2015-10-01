<?php

namespace CodeCommerce;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = ['category_id','name','description','price'];
    
    public function images(){
        return $this->hasMany('CodeCommerce\ProductImage');
    }

    public function category()
    {
        return $this->belongsTo('CodeCommerce\Category');
    }
}
