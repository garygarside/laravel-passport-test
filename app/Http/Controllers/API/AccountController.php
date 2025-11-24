<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->accounts);
    }

    public function create(CreateAccountRequest $request)
    {
        $account = $request->user()->accounts()->create([
            'balance' => 0,
        ]);

        return response()->json($account, 201);
    }

    public function show(Request $request, Account $account)
    {
        $account = $request->user()->accounts()->findOrFail($account->id);

        return response()->json($account);
    }
}
