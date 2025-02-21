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
    Schema::create('tokens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('account_id')->constrained()->onDelete('cascade');
        $table->string('token');
        $table->enum('type', ['bearer', 'api-key', 'login/password']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
