<?php
namespace App\Helpers;

trait HelperMessage
{
    private static function success() {
        return response()->json(['message' => 'Operação realizada com sucesso.'], 200);
    }

    private static function error($message = 'Falha ao realizar a operação.') {
        return response()->json(['message' => $message], 400);
    }
}
