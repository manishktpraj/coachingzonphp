<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsNotification extends Model
{
    protected $table="cs_notifications";
    protected $primaryKey = 'no_id';
} 