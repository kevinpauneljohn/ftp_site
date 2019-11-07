<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    public function tasks()
    {
        return $this->hasMany(task::class,'job_order_id');
    }
}
