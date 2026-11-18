<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $t) {
            $t->id();
            $t->string('name', 120);
            $t->string('phone', 40);
            $t->string('email', 160)->nullable();
            $t->string('service', 160)->nullable();
            $t->string('package', 200)->nullable();
            $t->string('preferred_time', 40)->nullable();
            $t->text('message')->nullable();
            $t->string('status', 20)->default('new')->index(); // new | contacted | qualified | won | lost
            $t->text('notes')->nullable();
            $t->string('source_page')->nullable();
            $t->string('ip', 45)->nullable();
            $t->string('user_agent', 255)->nullable();
            $t->boolean('mail_sent')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};