<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsVideo extends Model
{
    protected $table="cs_video";
    protected $primaryKey = 'video_id';
} 