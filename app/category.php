<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class category extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['name','permalink'];

    protected static $logAttributes = ['name','permalink'];

    public function products()
    {
        $this->hasMany(Product::class,'category_id','id');
    }
}

