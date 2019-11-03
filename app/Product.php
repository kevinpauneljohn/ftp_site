<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Gloudemans\Shoppingcart\Contracts\Buyable;

class Product extends Model implements Buyable
{
    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }
    public function getBuyableDescription($options = null) {
        return $this->title;
    }
    public function getBuyablePrice($options = null) {
        return $this->price;
    }
    public function getBuyableWeight($options = null){
        return $this->weight;
    }
    /*protected $casts = [
        'size' => 'array'
    ];*/
    public function users()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function categories()
    {
        return $this->belongsTo(category::class,'category_id','id');
    }

    public function buyer()
    {
        return $this->belongsToMany(User::class);
    }
}
