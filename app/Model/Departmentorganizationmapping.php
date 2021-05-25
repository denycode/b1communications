<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departmentorganizationmapping extends Model
{
    protected $table = 'departments_organizations';
    protected $timestamp = false;
    
    const UPDATED_AT=NULL;
    const CREATED_AT=NULL;
    const DELETED_AT=NULL;

    public function getUpdatedAtColumn() {
        return null;
    }
    public function getCreatedAtColumn() {
        return null;
    }
    public function getDeletedAtColumn() {
        return null;
    }
}
