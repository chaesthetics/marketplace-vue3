<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('user_id', 'created_by');

            $table->string('file_path')->required();
            $table->string('file_name')->required();
            $table->string('file_type')->required();
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->renameColumn('created_by', 'user_id');

        $table->dropColumn('file_path');
        $table->dropColumn('file_name');
        $table->dropColumn('file_type');
    }
};
