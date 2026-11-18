<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\Html;
use App\Support\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $q = Post::query();
        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('title', 'like', "%$s%")->orWhere('category', 'like', "%$s%")->orWhere('focus_keyword', 'like', "%$s%"));
        }
        if (in_array($request->query('status'), ['published', 'draft', 'scheduled'], true)) {
            match ($request->query('status')) {
                'published' => $q->published(),
                'draft' => $q->where('status', 'draft'),
                'scheduled' => $q->where('status', 'published')->where('published_at', '>', now()),
            };
        }

        return view('admin.posts.index', [
            'posts' => $q->latest('updated_at')->paginate(12)->withQueryString(),
            'counts' => ['all' => Post::count(), 'published' => Post::published()->count(), 'draft' => Post::where('status', 'draft')->count(), 'scheduled' => Post::where('status', 'published')->where('published_at', '>', now())->count()],
        ]);
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post(['status' => 'draft', 'author_name' => 'Samin Sajid']), 'categories' => $this->categories()]);
    }

    public function store(Request $request)
    {
        $post = new Post();
        $this->save($request, $post);

        return redirect()->route('admin.posts.edit', $post)->with('success', 'Post created.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', ['post' => $post, 'categories' => $this->categories()]);
    }

    public function update(Request $request, Post $post)
    {
        $this->save($request, $post);

        return back()->with('success', 'Post saved.');
    }

    public function destroy(Post $post)
    {
        Uploader::delete($post->cover_image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    public function toggle(Post $post)
    {
        if ($post->status === 'published') {
            $post->update(['status' => 'draft']);
        } else {
            $post->update(['status' => 'published', 'published_at' => $post->published_at ?: now()]);
        }

        return back()->with('success', $post->status === 'published' ? 'Post published.' : 'Post moved to drafts.');
    }

    private function categories()
    {
        return Post::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
    }

    private function save(Request $request, Post $post): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:190', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:80'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
            'author_name' => ['nullable', 'string', 'max:120'],
            'cover' => ['nullable', 'image', 'mimes:'.implode(',', Uploader::MIMES), 'max:5120'],
            'cover_alt' => ['nullable', 'string', 'max:190'],
            'remove_cover' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:120'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'focus_keyword' => ['nullable', 'string', 'max:120'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'noindex' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($data['slug'] ?: $data['title']);
        $base = $slug;
        $i = 2;
        while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $base.'-'.$i++;
        }

        $content = Html::clean($data['content'] ?? '');

        $post->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $content,
            'category' => $data['category'] ?? null,
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($data['published_at'] ?? null ?: $post->published_at ?: now()) : ($data['published_at'] ?? null),
            'author_name' => $data['author_name'] ?? null,
            'read_minutes' => Post::readMinutes($content),
            'cover_alt' => $data['cover_alt'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'focus_keyword' => $data['focus_keyword'] ?? null,
            'canonical_url' => $data['canonical_url'] ?? null,
            'noindex' => $request->boolean('noindex'),
        ]);

        if ($request->hasFile('cover')) {
            Uploader::delete($post->cover_image);
            $post->cover_image = Uploader::image($request->file('cover'), 'blog');
        } elseif ($request->boolean('remove_cover')) {
            Uploader::delete($post->cover_image);
            $post->cover_image = null;
        }

        $post->save();
    }
}
