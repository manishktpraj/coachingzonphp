<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsTransactionsDetail extends Model
{
    protected $table="cs_transaction_detail";
    protected $primaryKey = 'td_id';


    public function user1(){
    $this->belongsTo('CsTransactions','trans_id','td_trans_id');
}

    
    }  