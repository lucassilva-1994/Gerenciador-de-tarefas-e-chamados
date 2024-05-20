<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['departments', 'positions','employees'];
        foreach($tables as $table){
            Schema::table($table, function(Blueprint $table){
                $table->foreignUuid('created_by')->nullable()->references('id')->on('users');
                $table->foreignUuid('modified_by')->nullable()->references('id')->on('users');
            });
        }
    }

    public function down(): void
    {
        $tables = ['departments', 'positions','employees'];
        foreach($tables as $table){
            Schema::dropIfExists($table);
        }
    }
};
