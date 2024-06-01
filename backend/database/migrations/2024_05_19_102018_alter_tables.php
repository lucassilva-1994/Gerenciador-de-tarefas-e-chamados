<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tables = ['departments', 'positions', 'employees', 'projects', 'tasks', 'support_tickets', 'users'];
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignUuid('created_by')->nullable()->references('id')->on('employees');
                $table->foreignUuid('modified_by')->nullable()->references('id')->on('employees');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
