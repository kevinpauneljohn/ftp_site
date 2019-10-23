<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function products()
    {
        $this->hasMany(Product::class,'category_id','id');
    }
}

