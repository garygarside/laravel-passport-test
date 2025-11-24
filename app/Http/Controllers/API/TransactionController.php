<?php

namespace App\Http\Controllers\API;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Account;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private const TRANSACTIONS_PER_PAGE = 10;

    public function index(Request $request, Account $account)
    {
        $userAccount = $request->user()->accounts()->findOrFail($account->id);

        return $userAccount
            ->transactions()
            ->paginate(self::TRANSACTIONS_PER_PAGE);
    }

    public function create(CreateTransactionRequest $request, Account $account)
    {
        $userAccount = $request->user()->accounts()->findOrFail($account->id);

        if ($request->type === TransactionType::WITHDRAWAL->value && !$userAccount->canWithdraw($request->amount)) {
            return response()->json([
                'message' => 'Insufficient funds to withdraw',
                'amount' => $request->amount,
            ], 406);
        }

        $transaction = $userAccount->transactions()->create($request->only('type', 'amount'));

        return response()->json(new TransactionResource($transaction), 201);
    }
}
