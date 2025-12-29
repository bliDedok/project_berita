<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['category', 'user'])->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image']);

        $userId = Auth::id() ?? User::query()->value('id');
        if (! $userId) {
            return redirect()
                ->route('admin.posts.index')
                ->with('error', 'User belum tersedia. Silakan buat user terlebih dahulu.');
        }

        Post::create([
            'title' => $data['title'],
            'slug' => $this->generateUniqueSlug($data['title']),
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'category_id' => $data['category_id'],
            'user_id' => $userId,
            'image_path' => null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image']);

        $slug = $post->slug;
        if ($post->title !== $data['title'] || empty($slug)) {
            $slug = $this->generateUniqueSlug($data['title'], $post->id);
        }

        $post->update([
            'title' => $data['title'],
            'slug' => $slug,
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'category_id' => $data['category_id'],
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        try {
            $post->delete();

            return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
        } catch (\Throwable $exception) {
            return redirect()->route('admin.posts.index')->with('error', 'Gagal menghapus berita.');
        }
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if ($baseSlug === '') {
            $baseSlug = 'post';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
