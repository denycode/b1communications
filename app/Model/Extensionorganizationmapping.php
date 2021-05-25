<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Extensionorganizationmapping extends Model
{
    protected $table = 'extensions_organizations';
    protected $timestamp = false;
    const UPDATED_AT=NULL;
    public function getUpdatedAtColumn() {
        return null;
    }
}
