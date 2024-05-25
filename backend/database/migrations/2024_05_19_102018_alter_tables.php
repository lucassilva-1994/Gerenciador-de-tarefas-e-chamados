<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['departments', 'positions','employees','projects','tasks','support_tickets','users'];
        foreach($tables as $table){
            Schema::table($table, function(Blueprint $table){
                $table->foreignUuid('created_by')->nullable()->references('id')->on('employees');
                $table->foreignUuid('modified_by')->nullable()->references('id')->on('employees');
            });
        }
    }

    public function down(): void
    {
        $tables = ['departments', 'positions','employees','projects','tasks','support_tickets','users'];
        foreach($tables as $table){
            Schema::dropIfExists($table);
        }
    }
};
