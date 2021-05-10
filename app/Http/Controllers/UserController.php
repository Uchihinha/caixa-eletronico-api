<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get(Request $request) {
        $this->validate($request->all(), [
            's' => 'string'
        ]);

        $users = User::when(isset($request->s), function($q) use($request) {
            $q->where('name', 'ilike', "%$request->s%");
        })
        ->simplePaginate(100);

        return response()->json($users);
    }

    public function update(Request $request, int $id) {
        $validator = $this->validate($request->all(), [
            'name'          => 'max:255',
            'email'         => 'email|unique:users',
            'birth_date'    => 'date_format:Y-m-d',
            'role_id'       => 'numeric'
        ]);

        $data = $validator->validated();

        $user = User::where('id', $id)->firstOrFail();

        $user->update($data);

        return response()->json(['message' => 'Usuário alterado com sucesso!']);
    }

    public function create(Request $request) {
        $validator = $this->validate($request->all(), [
            'name'          => 'required|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|confirmed',
            'cpf'           => 'required|numeric|unique:users',
            'birth_date'    => 'required|date_format:Y-m-d',
            'role_id'       => 'required'
        ]);

        $data = $validator->validated();

        $data['password'] = Hash::make($request->password);

        User::create($data);

        return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
    }

    public function delete(int $id) {
        $user = User::where('id', $id)->firstOrFail();

        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso!']);
    }

    public function getStatement(Request $request, $accountId) {
        $this->validate($request->all(), [
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
            'type' => 'numeric'
        ]);

        $data = Statement::where('account_id', $accountId)
        ->when(isset($request->start_date), function($q) use($request) {
            $q->whereDate('created_at', '>=', $request->start_date);
        })
        ->when(isset($request->end_date), function($q) use($request) {
            $q->whereDate('created_at', '<=', $request->end_date);
        })
        ->when(isset($request->type), function($q) use($request) {
            $q->where('statement_type_id', $request->type);
        })
        ->with('type')
        ->orderByDesc('created_at')
        ->simplePaginate(100);

        return response()->json($data);
    }

    public function getAccounts() {
        return response()->json(auth()->user()->accounts);
    }
}
