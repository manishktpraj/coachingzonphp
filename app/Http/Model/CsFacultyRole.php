<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsFacultyRole extends Model
{
    protected $table="cs_faculty_role";
    protected $primaryKey = 'role_id';
} 