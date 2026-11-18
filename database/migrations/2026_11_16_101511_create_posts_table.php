<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('excerpt')->nullable();
            $t->longText('content')->nullable();
            $t->string('category', 80)->nullable();
            $t->string('cover_image')->nullable();   // path relative to /public
            $t->string('cover_alt')->nullable();
            $t->string('status', 20)->default('draft')->index(); // draft | published
            $t->timestamp('published_at')->nullable()->index();
            $t->string('author_name', 120)->nullable();
            $t->unsignedSmallInteger('read_minutes')->default(3);
            $t->unsignedInteger('views')->default(0);
            // SEO
            $t->string('meta_title')->nullable();
            $t->string('meta_description', 320)->nullable();
            $t->string('focus_keyword')->nullable();
            $t->string('canonical_url')->nullable();
            $t->string('og_image')->nullable();
            $t->boolean('noindex')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};