<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class task extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['job_order_id','created_by','title', 'description','deadline_date','deadline_time','assigned_to'];

    protected static $logAttributes = ['job_order_id','created_by','title', 'description','deadline_date','deadline_time','assigned_to'];

    public function users()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class,'job_order_id');
    }
}
