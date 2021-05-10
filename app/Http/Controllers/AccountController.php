<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Statement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccountController extends Controller
{
    //
    public function create(Request $request) {
        $validator = $this->validate($request->all(), [
            'user_id'           => 'required|numeric|unique:accounts,user_id,null,id,account_type_id,' . $request->account_type_id,
            'account_type_id'   => 'required|numeric|unique:accounts,account_type_id,null,id,user_id,' . $request->user()->id,
            'number'            => 'required|numeric',
            'agency'            => 'required|numeric',
            'balance'           => 'required|numeric'
        ]);

        $data = $validator->validated();

        Account::create($data);

        return response()->json(['message' => 'Conta criada com sucesso!'], 201);
    }

    public function deposit(Request $request, int $accountId) {
        $validator = $this->validate($request->all(), [
            'amount' => 'required|numeric|min:1'
        ]);

        $data = $validator->validated();
        $data['statement_type_id'] = 1;
        $data['account_id'] = $accountId;

        // MANDAR PRA FILA\
        DB::transaction(function () use($data, $request, $accountId) {
            Statement::create($data);

            $account = auth()->user()->accounts->where('id', $accountId)->first();
            $account->balance += $request->amount;
            $account->save();
        });

        return response()->json(['message' => 'Depósito realizado com sucesso!'], 201);
    }

    public function withdraw(Request $request, int $accountId) {
        $validator = $this->validate($request->all(), [
            'amount' => 'required|numeric|min:20'
        ]);

        $account = auth()->user()->accounts->where('id', $accountId)->first();

        $account->validateBalance($request->amount);

        $moneyBills = validateMoneyBill($request->amount);

        $data = $validator->validated();
        $data['statement_type_id'] = 2;
        $data['account_id'] = $accountId;

        // MANDAR PRA FILA
        DB::transaction(function () use($data, $request, $account) {
            Statement::create($data);

            $account->balance -= $request->amount;
            $account->save();
        });

        $message = formatWithdrawResponse($moneyBills);

        return response()->json(['message' => $message], 201);
    }

    public function find(int $accountId) {
        return response()->json(Account::find($accountId));
    }
}
