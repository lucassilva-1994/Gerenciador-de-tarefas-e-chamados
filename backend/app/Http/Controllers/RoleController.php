<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(Role::class,['employees','permissions'],null, []);
    }
}
