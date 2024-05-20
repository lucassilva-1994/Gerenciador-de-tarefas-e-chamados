<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Http\Requests\PositionRequest;
use App\Models\Position;

class PositionController extends Controller
{
    use HelperModel;
    public function showAll(){
        return Position::all();
    }

    public function showById(Position $position){
        return $position;
    }

    public function create(PositionRequest $request){
        return self::setData($request->all(), Position::class);
    }

    public function update(PositionRequest $request, Position $position){
        return self::updateData($request->all(), Position::class,['id' => $position->id]);
    }

    public function delete(Position $position){
        return self::setStatusDeleted(Position::class,['id' => $position->id]);
    }
}
