<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'orders',
        'status'
    ];

    protected $casts = [
        'orders' => 'array'
    ];

    public function setMetaAttribute($value)
    {
        $list = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $list[] = $array_item;
            }
        }

        $this->attributes['orders'] = json_encode($list);
    }
}
