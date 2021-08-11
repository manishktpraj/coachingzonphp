<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsPermission extends Model
{
    protected $table="cs_permission";
    protected $primaryKey = 'permission_id';
} 

