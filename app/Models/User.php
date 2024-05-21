<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class User extends AuthenticatableUser implements Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'firstname', 'lastname', 'email', 'number', 'password',
    ];

    
}
