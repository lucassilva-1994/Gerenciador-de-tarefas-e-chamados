<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'users';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name',100);
            $table->string('username', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 60);
            $table->string('photo', 100)->nullable();
            $table->string('visibility')->default('Operacional')
            ->comment('User visibility: 
                      1 = SUPER ADMIN - Full access to all areas of the system.
                      2 = MANAGER - Access to tasks and data for their department.
                      3 = OPERATIONAL (STAFF) - Access only to their own tasks.');
            $table->uuid('created_by')->nullable();
            $table->uuid('modified_by')->nullable();
            $table->foreignUuid('department_id')->references('id')->on('departments');
            $table->boolean('deleted')->default(0);
            $table->dateTime('password_expires_at')->default(now()->addHours(3));
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
