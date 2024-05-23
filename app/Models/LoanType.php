<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LoanType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'interest_rate'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
