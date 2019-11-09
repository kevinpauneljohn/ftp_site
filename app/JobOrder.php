<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrder extends Model
{
    use SoftDeletes;

    public function tasks()
    {
        return $this->hasMany(task::class,'job_order_id');
    }
}
