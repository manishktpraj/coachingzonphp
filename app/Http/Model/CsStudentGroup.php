<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsStudentGroup extends Model
{
    protected $table="cs_student_group";
    protected $primaryKey = 'sg_id';
} 