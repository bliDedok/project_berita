<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Post;
use App\Services\CuacaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, CuacaService $cuacaService): View
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

        // ====== Daftar bacaan (punya kamu) ======
        $savedIds = auth()->check()
            ? auth()->user()->daftarBacaan()->pluck('posts.id')->toArray()
            : [];

        // ====== CUACA ======
        $cities = config('services.cuaca.cities', ['Denpasar']);
        $selectedCity = $request->get('city', config('services.cuaca.default_city', 'Denpasar'));

        // kalau user iseng kirim city di luar list, fallback ke default
        if (!in_array($selectedCity, $cities)) {
            $selectedCity = config('services.cuaca.default_city', 'Denpasar');
        }

        $cuaca = $cuacaService->get($selectedCity);

        return view('home', compact(
            'posts',
            'kategoris',
            'savedIds',
            'cuaca',
            'cities',
            'selectedCity'
        ));
    }

    public function show(Post $post): View
    {
        $post->increment('jumlah_pembaca');
        return view('berita.show', compact('post'));
    }
}
