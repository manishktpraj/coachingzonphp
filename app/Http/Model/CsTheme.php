<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsTheme extends Model
{
    protected $table="cs_theme_setting";
    protected $primaryKey = 'theme_id';
} 