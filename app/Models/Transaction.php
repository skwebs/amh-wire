<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'particulars', 'amount', 'type', 'datetime'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected $casts = [
        'amount' => 'decimal:2', // Assuming amount is stored in rupees
        'created_at' => 'datetime',
        'datetime' => 'datetime',
    ];
}
