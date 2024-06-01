<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'departments';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name', 40);
            $table->boolean('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->unique(['name','company_id'],'unique_name_department_per_company');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
