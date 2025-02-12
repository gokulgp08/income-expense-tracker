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

        return $this->belongsTo(AccountHead::class, 'credit_id', 'id')
                    ->whereNotIn('slug', ['cash', 'bank']);
    }

    /**
     * Relationship for the debit account head.
     */
    public function debitAccountHead()
    {

        return $this->belongsTo(AccountHead::class, 'debit_id', 'id')
                    ->whereNotIn('slug', ['cash', 'bank']);
    }

    public function cashAccountHead()
    {

        return $this->belongsTo(AccountHead::class, 'credit_id', 'id')
                    ->where('slug', 'cash');
    }

    /**
     * Relationship for the cash account head.
     */
    public function bankAccountHead()
    {

        return $this->belongsTo(AccountHead::class, 'debit_id', 'id')
                    ->where('slug', 'bank');
    }
}
