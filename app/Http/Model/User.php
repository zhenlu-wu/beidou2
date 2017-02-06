<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table='user';    //务必与数据库去除前缀的表名一致
    protected  $primaryKey='id';
    public $timestamps=false;
}
