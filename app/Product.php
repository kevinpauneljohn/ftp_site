<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function categories()
    {
        return $this->belongsTo(category::class,'category_id','id');
    }
}
