<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class JobOrder extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['created_by','category_id','title', 'description','customer_name','customer_contact_number','pickup_date','pickup_time','amount','down_payment'];

    protected static $logAttributes = ['created_by','category_id','title', 'description','customer_name','customer_contact_number','pickup_date','pickup_time','amount','down_payment'];

    public function tasks()
    {
        return $this->hasMany(task::class,'job_order_id');
    }
}
