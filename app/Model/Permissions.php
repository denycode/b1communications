<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    //use SoftDeletes;
    protected $table = 'permissions';
    //protected $primaryKey = 'permission_id';
    
    public function profile() {
        return $this->hasOne(Profile::class,'profile_id','profile_id');
    }
}
