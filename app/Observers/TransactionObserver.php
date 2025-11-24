<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $transaction->account->calculateBalance();
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        $transaction->account->calculateBalance();
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $transaction->account->calculateBalance();
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        $transaction->account->calculateBalance();
    }
}
