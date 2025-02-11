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
}
