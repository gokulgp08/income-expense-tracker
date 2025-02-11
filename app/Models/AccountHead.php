<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AccountHead extends Model
{
    protected $table = "account_head";
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();

        // Before creating a new record
        static::creating(function ($accountHead) {
            $accountHead->slug = Str::slug($accountHead->name);

            if (Auth::check()) {
                $accountHead->user_id = Auth::id();
            }
        });

        // If you also want to update the slug when the name changes:
        static::updating(function ($accountHead) {
            $accountHead->slug = Str::slug($accountHead->name);
        });
    }
}
