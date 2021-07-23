<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsStudent extends Model
{
    protected $table="cs_student";
    protected $primaryKey = 'student_id';
} 