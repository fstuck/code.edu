<?php

namespace CodeCommerce;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = ['name','description','price','featured','recommended'];
}