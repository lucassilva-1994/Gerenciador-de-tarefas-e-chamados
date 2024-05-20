<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HelperModel;
    public function signIn(Request $request){
        $user = User::whereHas('employee', function($query) use ($request){
            $query->where('email', $request->email);
        })->first();
        if(!$user->employee->deleted){
            if(!$token = auth()->attempt(['employee_id' => $user->employee->id,'password' => $request->password])){
                return response()->json(['Credenciais inválidas'],401);
            }
            return response()->json($token);
        }
        return response()->json("Usuário inativo");
    }

    public function whoAmI(){
        return auth()->user()->load(['company','employee']);
    }

    public function showAll(){
        return User::whereCompanyId(auth()->user()->company_id)->get();
    }

    public function showById(User $user){
        return $user->company_id !== auth()->user()->company_id ? abort(403, 'Acesso negado') : $user->load(['company:id,legal_name','employee:id,name,email','position']);
    }

    public function create(UserRequest $request){
        return self::setData($request->all(), User::class); 
    }
}
