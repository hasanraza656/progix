<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Safe to run on servers where this table was already created by hand.
        if (Schema::hasTable('settings')) {
            return;
        }

        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key', 80)->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
