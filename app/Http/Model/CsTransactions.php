<?php namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CsTransactions extends Model
{
    protected $table="cs_transactions";
    protected $primaryKey = 'trans_id';

    public function user()
    {
        return $this->hasmany(CsTransactionsDetail::class, 'td_trans_id', 'trans_id');
    }
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }
    } 