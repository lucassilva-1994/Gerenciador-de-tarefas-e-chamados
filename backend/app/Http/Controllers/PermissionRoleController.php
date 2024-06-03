<?php

namespace App\Http\Controllers;

use App\Helpers\HelperMessage;
use Illuminate\Support\Facades\DB;

class PermissionRoleController extends Controller
{
    use HelperMessage;
    public function store(string $roleId, string $permissionId){
        if(!DB::table('permission_role')->whereRoleIdAndPermissionId($roleId, $permissionId)->exists()){
            if(DB::table('permission_role')->insert(['role_id' => $roleId, 'permission_id' => $permissionId])){
                return self::success();
            }
            return self::error();
        }
        return self::error('Permissão já adicionado nesse papel.');
    }

    public function delete(string $roleId, string $permissionId){
        if(DB::table('permission_role')->whereRoleIdAndPermissionId($roleId, $permissionId)->delete()){
            return self::success();
        }
        return self::error();
    }
}
