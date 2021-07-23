<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsStaff extends Model
{
    protected $table="cs_staff";
    protected $primaryKey = 'staff_id';
} 