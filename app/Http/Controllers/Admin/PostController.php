<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Kategori;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['kategori', 'user'])->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('admin.posts.create', compact('kategoris'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
    $data = $request->validated();

    $gambarPath = $request->file('gambar')->store('posts', 'public'); 

    Post::create([
    'judul' => $data['judul'],
    'slug' => $this->generateUniqueSlug($data['judul']),
    'ringkasan' => $data['ringkasan'],
    'konten' => $data['konten'],
    'kategori_id' => $data['kategori_id'],
    'user_id' => auth()->id(),
    'gambar' => $gambarPath,
    'jumlah_pembaca' => 0,
    ]);

    return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post): View
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('admin.posts.edit', compact('post', 'kategoris'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        $slug = $post->slug;
        if ($post->judul !== $data['judul'] || empty($slug)) {
            $slug = $this->generateUniqueSlug($data['judul'], $post->id);
        }

        $gambarPath = $post->gambar;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('posts', 'public');
        }

        $post->update([
            'judul'       => $data['judul'],
            'slug'        => $slug,
            'ringkasan'   => $data['ringkasan'],
            'konten'      => $data['konten'],
            'kategori_id' => $data['kategori_id'],
            'gambar'      => $gambarPath,
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($judul) ?: 'post';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
