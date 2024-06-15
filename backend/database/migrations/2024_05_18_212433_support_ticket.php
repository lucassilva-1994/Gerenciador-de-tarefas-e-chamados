<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'support_tickets';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('title',100);
            $table->longText('description')->nullable();
            $table->enum('status',['OPEN','IN_PROGRESS','COMPLETED'])->default('OPEN');
            $table->boolean('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('owner_id')->nullable()->references('id')->on('employees');
            $table->foreignUuid('viewed_by')->nullable()->references('id')->on('employees');
            $table->foreignUuid('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->foreignUuid('project_id')->nullable()->references('id')->on('projects');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
