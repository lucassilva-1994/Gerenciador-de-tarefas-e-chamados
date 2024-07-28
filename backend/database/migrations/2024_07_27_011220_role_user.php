<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'role_user';
    public function up(): void
    {
       Schema::create($this->table, function(Blueprint $table){
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUuid('role_id')->references('id')->on('roles')->cascadeOnDelete();
       });
    }
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
