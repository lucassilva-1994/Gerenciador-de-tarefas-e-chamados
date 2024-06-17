<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'employees';
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->enum('visibility_level',['GENERAL','RESTRICTED'])->default('RESTRICTED');
            $table->boolean('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('position_id')->references('id')->on('positions')->cascadeOnDelete();
            $table->foreignUuid('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->unique(['email','company_id'],'unique_email_per_company');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
