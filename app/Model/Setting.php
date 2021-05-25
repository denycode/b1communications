<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    //use SoftDeletes;
    const USERS = 20;
    const PROFILE_MASTER = 21;
}
