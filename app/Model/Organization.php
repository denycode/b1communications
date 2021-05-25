<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;
    protected $table = 'organizations';

    public function server(){
        return $this->hasOne(Server::class,'id','server_ID');
    }
    public function phonenumbers(){
        return $this->hasMany(Phoneorganizationmapping::class,'organization_id','id');
    }

}
