<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::with('kategori')
            ->orderByDesc('tanggal_unggah');

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $posts = $query->paginate(6)->withQueryString();
        $kategoris = Kategori::orderBy('nama')->get();

        return view('home', compact('posts', 'kategoris'));
    }

    public function show(Post $post): View
    {
        $post->increment('jumlah_pembaca');
        return view('berita.show', compact('post'));
    }
}
