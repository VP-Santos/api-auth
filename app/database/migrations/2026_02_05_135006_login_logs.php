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
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            // $table->foreignId('user_id')
            //     ->constrained()
            //     ->cascadeOnDelete();
            $table->date('last_login_in');
            $table->date('last_logout_in');
            $table->string('token');
            // $table->string('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
