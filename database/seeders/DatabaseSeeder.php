<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Initial admin — change the password from Admin > Account after first login.
        User::firstOrCreate(
            ['email' => 'admin@progixdigital.com'],
            ['name' => 'Admin', 'password' => Hash::make('f17@AYDS')]
        );

        // Sample posts: only created once (never overwrites edits made in the admin panel).
        foreach (require database_path('seeders/data/posts.php') as $p) {
            $html = '<p>'.$p['intro'].'</p>';
            foreach ($p['sections'] as $s) {
                $html .= '<h2>'.e($s[0]).'</h2><p>'.e($s[1]).'</p>';
                if (! empty($s[2])) {
                    $html .= '<ul>'.collect($s[2])->map(fn ($li) => '<li>'.e($li).'</li>')->implode('').'</ul>';
                }
            }
            $kw = ucfirst($p['keyword']);
            $html .= '<h2>Putting '.e($p['keyword']).' into practice</h2>'
                .'<p>'.e($kw).' works best when it is consistent, measured and tied to a clear business goal. At Progix Digital we have applied these ideas across 1,200+ projects in more than 37 industries, and the same principles hold whether you are a start-up, a local business or an established brand.</p>'
                .'<p>'.$p['outro'].'</p>';

            // Long-form, answer-first version when one exists
            $long = (require database_path('seeders/data/long-posts.php'))[$p['slug']] ?? null;
            if ($long) {
                $html = $long['body'];
                $p['excerpt'] = $long['excerpt'];
                $p['meta_title'] = $long['meta_title'];
                $p['meta_desc'] = $long['meta_desc'];
            }

            Post::firstOrCreate(['slug' => $p['slug']], [
                'title' => $p['title'],
                'excerpt' => $p['excerpt'],
                'content' => $html,
                'category' => $p['category'],
                'cover_image' => $p['cover'],
                'cover_alt' => $p['cover_alt'],
                'status' => 'published',
                'published_at' => $p['date'],
                'author_name' => 'Samin Sajid',
                'read_minutes' => Post::readMinutes($html),
                'meta_title' => $p['meta_title'],
                'meta_description' => $p['meta_desc'],
                'focus_keyword' => $p['keyword'],
                'og_image' => $p['cover'],
            ]);
        }
    }
}
