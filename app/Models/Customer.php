<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'address'];


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // public function latestTransaction()
    // {
    //     return $this->hasOne(Transaction::class)->latest();
    // }

    // Method to get the latest transaction
    public function latestTransaction()
    {
        return $this->hasOne(Transaction::class)->latestOfMany();
    }

    public function getBalanceAttribute()
    {
        $debits = $this->transactions()->where('type', 'debit')->sum('amount');
        $credits = $this->transactions()->where('type', 'credit')->sum('amount');
        return   $debits - $credits;
    }
}