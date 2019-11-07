<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class,'job_order_id');
    }
}
