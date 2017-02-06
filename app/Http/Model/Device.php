<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table = 'device';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
