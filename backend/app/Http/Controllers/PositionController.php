<?php

namespace App\Http\Controllers;
use App\Http\Requests\PositionRequest;
use App\Models\Position;

class PositionController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(Position::class,['department','employees','createdBy','modifiedBy'], PositionRequest::class);
    }
}
