<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('api_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('base_url');
            $table->enum('token_type', ['bearer', 'api-key', 'login/password']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_services');
    }
};
