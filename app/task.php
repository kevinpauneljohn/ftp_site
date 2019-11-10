<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class task extends Model
{
    use SoftDeletes;
    public function users()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class,'job_order_id');
    }
}
