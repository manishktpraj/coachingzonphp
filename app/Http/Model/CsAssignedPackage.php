<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsAssignedPackage extends Model
{
    protected $table="cs_assigned_packages";
    protected $primaryKey = 'p_id';
} 