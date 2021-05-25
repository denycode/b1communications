<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autoattendantorganizationmapping extends Model
{
    protected $table = 'autoattendant_organizations';
    protected $timestamp = false;
}
