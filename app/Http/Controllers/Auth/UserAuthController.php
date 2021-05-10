<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserAuthController extends Controller
{
    //
    public function register(Request $request)
    {
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

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['message' => 'Usuário registrado com sucesso!', 'user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $validator = $this->validate($request->all(), [
            'email'     => 'email|required',
            'password'  => 'required'
        ]);

        $data = $validator->validated();

        if (!auth()->attempt($data)) {
            throw new UnauthorizedHttpException('oAuth2', 'Email ou senha incorretos!');
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response()->json(['user' => auth()->user(), 'token' => $token]);
    }

    public function logout()
    {
        auth()->user()->token()->revoke();

        return response()->json(['message' => 'Logout efetuado com sucesso!']);
    }
}
