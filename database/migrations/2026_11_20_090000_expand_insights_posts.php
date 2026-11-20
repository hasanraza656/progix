<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replace the short starter articles with the long-form, answer-first versions.
     * Only touches posts that are still short, so anything edited/expanded in the admin is left alone.
     */
    public function up(): void
    {
        if (! Schema::hasTable('posts')) {
            return;
        }

        $long = require database_path('seeders/data/long-posts.php');

        foreach ($long as $slug => $new) {
            $post = Post::where('slug', $slug)->first();
            if (! $post || str_word_count(strip_tags((string) $post->content)) >= 900) {
                continue;
            }

            $post->update([
                'excerpt' => $new['excerpt'],
                'content' => $new['body'],
                'meta_title' => $new['meta_title'],
                'meta_description' => $new['meta_desc'],
                'read_minutes' => Post::readMinutes($new['body']),
            ]);
        }
    }

    public function down(): void
    {
        // Content update only; nothing to roll back.
    }
};
