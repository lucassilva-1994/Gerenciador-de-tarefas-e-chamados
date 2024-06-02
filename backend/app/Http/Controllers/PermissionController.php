<?php

namespace App\Http\Controllers;

use App\Models\Permission;

class PermissionController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(Permission::class,['roles'],null,[]);
    }
}
