<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autoattendant extends Model
{
    use SoftDeletes;
    protected $table = 'ivr_details';
}
