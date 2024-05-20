<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    use HelperModel;
    public function create(CompanyRequest $request){
        if(self::setData($request->all(), Company::class)){
            return "Tudo certo!!!";
        }    
        return "Falha!!!";
    }
}
