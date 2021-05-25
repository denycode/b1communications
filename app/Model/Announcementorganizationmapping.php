<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcementorganizationmapping extends Model
{
    protected $table = 'announcements_organizations';
    protected $timestamp = false;
}
