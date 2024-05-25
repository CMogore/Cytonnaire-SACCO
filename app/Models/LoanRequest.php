<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'payable_amount',
        'payment_period',
        'payment_per_month',
        'type_id',

        

    ];
    // Loan.php
public function status()
{
    return $this->belongsTo(Status::class, 'status_id');
}

public function type()
{
    return $this->belongsTo(LoanType::class, 'type_id');
}

}
