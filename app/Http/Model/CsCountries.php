<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsCountries extends Model
{
    protected $table="cs_countries";
    protected $primaryKey = 'id';
} 