<?php

namespace App\Helpers;

use App\Models\Scopes\{CompanyScope, NotDeletedScope};
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

trait HelperModel
{
    use HelperMessage;
    private static function setData(array $data, $model, $isSeeder = false)
    {
        $fillable = (new $model)->getFillable();
        //Verifica se os campos enviados na requisição está na propriedade Fillable no Model, caso não esteja o campo que foi enviado no corpo da requisição não será persistido
        $data = array_intersect_key($data, array_flip($fillable));
        $data['id'] = self::setUuid();
        $data['sequence'] = self::setSequence($model);
        $data['created_at'] = now();
        //Logo abaixo está a verificação se os campos existem na propriedade fillable, caso existir a trait fica responsável por setar esses valores, sem a necessidade de enviar na requisição
        if (in_array('created_by', $fillable) && auth()->check()) {
            $data['created_by'] = auth()->user()->employee_id;
        }
        if (in_array('company_id', $fillable) && auth()->check()) {
            $data['company_id'] = auth()->user()->company_id;
        }
        if (in_array('password', $fillable)) {
            $data['password'] = bcrypt($data['password']);
        }
        if (isset($data['name']) && !$isSeeder) {
            $data['name'] = self::ensureUniqueValue("name",$data['name'], $model);
        }
        //Success e Error são métodos presentes na trait HelperMessage, vai retornar uma mensagem generica em caso de sucesso ou erro, sem precisar setar no controller, ou seja nesse caso os controller estão apenas enviondo os dados sem a necessidade de tratar retorno
        try {
            $model::updateOrCreate($data);
            return self::success();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private static function updateData(array $data, $model, array $where)
    {
        //Verificando se há um ID na tabela, caso não existir o ID informado, o metodo setData será chamado.
        if(!$model::whereId($where['id'])->exists()){
            return self::setData($data, $model);
        }
        $fillable = (new $model)->getFillable();
        $data = array_intersect_key($data, array_flip($fillable));
        $data['updated_at'] = now();
        if (in_array('modified_by', $fillable) && auth()->check()) {
            $data['modified_by'] = auth()->user()->employee_id;
        }
        try {
            $model::updateOrCreate($where, $data);
            return self::success();
        } catch (\Throwable $th) {
            return self::error();
        }
    }

    // Método responsável por mudar o status de visivel para excluído
    private static function setStatusDeleted($model, $where)
    {
        $data['deleted'] = 1;
        $data['updated_at'] = now();
        if (in_array('modified_by', (new $model)->getFillable()) && auth()->check()) {
            $data['modified_by'] = auth()->user()->employee_id;
        }
        try {
            $model::updateOrCreate($where, $data);
            return self::success();
        } catch (\Throwable $th) {
            return self::error();
        }
    }

    //Pegando o último registro na tabela em questão, ignorando se os mesmos fazem parte da mesma empresa ou se está com o campo "deleted" como "true"
    private static function setSequence($model)
    {
        return DB::transaction(function () use ($model) {
            return $model::withoutGlobalScope(CompanyScope::class, NotDeletedScope::class)
                ->lockForUpdate()
                ->max('sequence') + 1;
        });
    }

    private static function setUuid()
    {
        return Uuid::uuid7(now());
    }

    //Método que vai garantir que o valor de uma propriedade seja único, caso o valor informado já existir, vai ser inserido números sequenciais na frente do valor informado
    private static function ensureUniqueValue($field, $value, $model)
    {
        $originalValue = $value;
        $counter = 1;
        while ($model::where($field, $value)->exists()) {
            $value = "{$originalValue} ({$counter})";
            $counter++;
        }
        return $value;
    }
}
