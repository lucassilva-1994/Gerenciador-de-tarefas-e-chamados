<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    use HelperModel;
    //O modelo que vai será usado nos métodos abaixo
    private $model;
    //A request que será referênciado abaixo
    private $request;
    //Os relacionamentos da classe modelo que foi informado.
    private $relationships;
    //Aqui são os campos que deseja que seja filtrado pelo filtro Search...
    private $searchProperties;

    public function __construct($model, $relationships, $request, $searchProperties = [])
    {
        $this->model = $model;
        $this->relationships = $relationships;
        $this->request = $request;
        $this->searchProperties = $searchProperties;
    }

    public function show(Request $request)
    {
        //abort(403);
        $query = $this->model::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                foreach ($this->searchProperties as $key => $value) {
                    if (is_array($value)) {
                        if (method_exists($this->model, $key)) {
                            $query->orWhereHas($key, function ($query) use ($search, $value) {
                                $query->where(function ($query) use ($search, $value) {
                                    foreach ($value as $property) {
                                        $query->orWhere($property, 'like', "%$search%");
                                    }
                                });
                            });
                        }
                    } else {
                        $query->orWhere($value, 'like', "%$search%");
                    }
                }
            });
        }
        return response()->json([
            'pages' => ceil($query->paginate()->total() / $request->query('perPage', 15)),
            'total' => $query->paginate()->total(),
            'itens' => $query->paginate($request->query('perPage', 15))->load($this->relationships)
        ]);
    }

    public function showWithoutPagination(Request $request){
        $fields = $request->has('fields') ? explode(',', $request->fields) : ['*'];
        $relationships = $request->has('relationships') ? explode(',', $request->relationships) : [];
        return $this->model::select($fields)->with($relationships)->get();
    }
    

    public function showById(string $id)
    {
        return $this->model::findOrFail($id)->load($this->relationships);
    }

    public function store()
    {
        return self::setData(app($this->request)->all(), $this->model);
    }

    public function update(string $id)
    {
        return self::updateData(app($this->request)->all(), $this->model, ['id' => $id]);
    }

    public function delete(string $id)
    {
        return self::setStatusDeleted($this->model, ['id' => $id]);
    }
}
