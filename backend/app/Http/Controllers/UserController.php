<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(
            User::class,
            UserRequest::class,
            ['department','createdBy','modifiedBy'],
            ['name', 'username', 'email', 'visibility','department' => ['departments.name']]
        );
    }
    
    public function signIn(UserRequest $request)
    {
        $credentials = [
            (filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username') => $request->login,
            'password' => $request->password,
            'deleted' => 0
        ];
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'errors' => [
                    'credentials' => 'Credenciais inválidas ou usuário inativo.'
                ]
            ], 401);
        }
        
        return response()->json([
            'token' => auth()->attempt($credentials)
        ], 200);
    }

    public function forgotPassword(UserRequest $request)
    {
        return response()->json([
            'message' => $request->email
        ]);
    }

    public function profile(){
        return auth()->user()->load('department');
    }

    public function changePassword(UserRequest $request){
        if(self::updateRecord(User::class, $request->only('password'),['id' => $request->id])){
            return response()->json([
                'message' => 'Senha atualizada com sucesso.'
            ]);
        }
    }

    public function signOut() {
        auth()->logout(true);
    }
}
