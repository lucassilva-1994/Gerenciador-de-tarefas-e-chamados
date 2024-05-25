<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;

class CRUDController extends Controller
{
    use HelperModel;
    private $model;
    private $request;
    private $relationships;

    public function __construct($model, $relationships, $request)
    {
        $this->model = $model;
        $this->relationships = $relationships;
        $this->request = $request;
    }

    public function show()
    {
        return $this->model::get()->load($this->relationships);
    }

    public function showById(string $id){
        return $this->model::findOrFail($id)->load($this->relationships);
    }

    public function store()
    {
        return self::setData(app($this->request)->all(), $this->model);
    }

    public function update(string $id)
    {
        return self::updateData(app($this->request)->all(),$this->model, ['id' => $id]);
    }

    public function delete(string $id){
        return self::setStatusDeleted($this->model,['id' => $id]);
    }
}
