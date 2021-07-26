<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsWalletTransaction extends Model
{
    protected $table="cs_wallet_transaction";
    protected $primaryKey = 'wtrans_id';
} 