<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsFaculty extends Model
{
    protected $table="cs_faculty";
    protected $primaryKey = 'faculty_id';
} 