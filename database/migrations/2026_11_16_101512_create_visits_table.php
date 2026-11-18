<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $t) {
            $t->id();
            $t->date('visited_on');
            $t->string('visitor_hash', 40);
            $t->string('path', 191);
            $t->string('referrer_host', 120)->nullable();
            $t->string('device', 10)->default('desktop');
            $t->timestamp('created_at')->nullable();
            $t->index(['visited_on', 'visitor_hash']);
            $t->index('path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};