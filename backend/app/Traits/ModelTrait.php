<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

trait ModelTrait
{
    private static function createRecord(string $model, array $data): JsonResponse
    {
        $fillable = (new $model)->getFillable();
        $data = array_intersect_key($data, array_flip($fillable));
        $data['id'] = self::generateUuid();
        $data['sequence'] = self::setSequenceNumber($model);
        $data['created_at'] = now();
        if (in_array('password', $fillable)) {
            $data['password'] = bcrypt($data['password']);
        }
        if (in_array('user_id', $fillable) && auth()->check()) {
            $data['user_id'] = auth()->user()->id;
        }
        if (in_array('created_by', $fillable) && auth()->check()) {
            $data['created_by'] = auth()->user()->id;
        }
        if (in_array('owner_id', $fillable) && auth()->check() && auth()->user()->visibility == 3) {
            $data['owner_id'] = auth()->user()->id;
        }
        if (in_array('department_id', $fillable) && auth()->check() && auth()->user()->visibility == 2) {
            $data['department_id'] = auth()->user()->department_id;
        }
        try {
            return response()->json([
                'message' => 'Os dados foram cadastrados com sucesso.',
                'data' => $model::updateOrCreate($data)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public static function updateRecord(string $model, array $data, array $where): JsonResponse
    {
        $fillable = (new $model)->getFillable();
        $data = array_intersect_key($data, array_flip($fillable));
        if (in_array('password', $fillable) && array_key_exists('password', $data)) {
            $data['password'] = bcrypt($data['password']);
        }
        if (in_array('modified_by', $fillable) && auth()->check()) {
            $data['modified_by'] = auth()->user()->id;
        }
        $data['updated_at'] = now();
        try {
            return response()->json([
                'message' => 'As alterações foram salvas com sucesso.',
                'data' => $model::updateOrCreate($where, $data)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro durante a atualização. Por favor, tente novamente.',
                'data' => null
            ], 400);
        }
    }

    private static function generateUuid()
    {
        return Uuid::uuid7(now());
    }

    private static function setSequenceNumber(string $model): int
    {
        return $model::max('sequence') + 1;
    }

    public static function markAsDeleted(string $model, array $where): JsonResponse
    {
        $data['deleted'] = 1;
        $data['updated_at'] = now();
        try {
            $model::updateOrCreate($where, $data);
            return response()->json([
                'message' => 'Registro excluído com sucesso.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível excluir o registro. Por favor, tente novamente.'
            ], 400);
        }
    }
}
