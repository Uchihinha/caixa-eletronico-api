<?php

namespace App\Models;

use App\Traits\ValidateAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, ValidateAccount;

    protected $fillable = [
        'user_id',
        'account_type_id',
        'number',
        'agency',
        'balance'
    ];

    protected $casts = [
        'balance'   => 'float'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
