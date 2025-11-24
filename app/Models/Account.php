<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'balance',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function canWithdraw(float $amount): bool
    {
        return $this->balance >= $amount;
    }

    public function calculateBalance(): void
    {
        $this->balance = $this->transactions->reduce(function ($balance, $transaction) {
            return ($transaction->type->value === TransactionType::DEPOSIT->value)
                ? $balance + $transaction->amount
                : $balance - $transaction->amount;
        }, 0);

        $this->save();
    }
}
