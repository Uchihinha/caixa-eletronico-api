<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'statement_type_id',
        'destination_account_id',
        'amount'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'amount'    => 'float'
    ];

    public function type() {
        return $this->hasOne(StatementType::class, 'id', 'statement_type_id');
    }
}
