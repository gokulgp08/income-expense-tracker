<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;



class Transaction extends Model
{
    protected $table = "transactions";
    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        // Before creating a new record
        static::creating(function ($transaction) {

            if (Auth::check()) {
                $transaction->user_id = Auth::id();
            }
        });

        
    }

    public function creditAccountHead()
    {

        return $this->belongsTo(AccountHead::class, 'credit_id', 'id');
                    // ->whereNotIn('slug', ['cash', 'bank']);
    }

    /**
     * Relationship for the debit account head.
     */
    public function debitAccountHead()
    {

        return $this->belongsTo(AccountHead::class, 'debit_id', 'id');
                    // ->whereNotIn('slug', ['cash', 'bank']);
    }

    public function creditCash()
    {
        return $this->belongsTo(AccountHead::class, 'credit_id');
    }

    public function debitCash()
    {
        return $this->belongsTo(AccountHead::class, 'debit_id');
    }

    public function creditBank()
    {
        return $this->belongsTo(AccountHead::class, 'credit_id');
    }

    public function debitBank()
    {
        return $this->belongsTo(AccountHead::class, 'debit_id');
    }

    
    public function voucherNumber()
    {

        return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
                    // ->whereNotIn('slug', ['cash', 'bank']);
    }

}
