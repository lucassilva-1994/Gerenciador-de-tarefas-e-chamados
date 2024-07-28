<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'roles';
    public function up(): void
    {
       Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name', 40);
            $table->string('description', 255)->nullable();
            $table->boolean('deleted')->default(0);
            $table->foreignUuid('created_by')->references('id')->on('users');
            $table->foreignUuid('modified_by')->references('id')->on('users');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
       });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
