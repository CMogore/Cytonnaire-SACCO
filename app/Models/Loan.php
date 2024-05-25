<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    // Loan.php
public function status()
{
    return $this->belongsTo(Status::class, 'status_id');
}

public function type()
{
    return $this->belongsTo(LoanType::class, 'type_id');
}
public function user()
    {
        return $this->belongsTo(User::class);
    }

}
