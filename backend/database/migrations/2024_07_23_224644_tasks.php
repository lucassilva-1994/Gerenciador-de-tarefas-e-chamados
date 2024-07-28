<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'tasks';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('title', 40);
            $table->longText('description');
            $table->boolean('is_done')->default(0);
            $table->foreignUuid('created_by')->nullable()->references('id')->on('users');
            $table->foreignUuid('modified_by')->nullable()->references('id')->on('users');
            $table->foreignUuid('project_id')->nullable()->references('id')->on('projects');
            $table->foreignUuid('owner_id')->nullable()->references('id')->on('users');
            $table->boolean('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
