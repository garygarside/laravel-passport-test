<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Http\Resources\TransactionResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[UseResource(TransactionResource::class)]
class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'type',
        'amount',
    ];

    protected $casts = [
        'type' => TransactionType::class,
        'amount' => 'float',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
