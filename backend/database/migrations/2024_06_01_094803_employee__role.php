<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'employee_role';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->foreignUuid('employee_id')->references('id')->on('employees');
            $table->foreignUuid('role_id')->references('id')->on('roles');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
