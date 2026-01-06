<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class DaftarBacaanController extends Controller
{
    public function toggle(Post $post): RedirectResponse
    {
        $user = auth()->user();

        $exists = $user->daftarBacaan()
            ->where('post_id', $post->id)
            ->exists();

        if ($exists) {
            $user->daftarBacaan()->detach($post->id);
            return back()->with('success', 'Dihapus dari daftar bacaan.');
        }

        $user->daftarBacaan()->attach($post->id);
        return back()->with('success', 'Disimpan ke daftar bacaan.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        auth()->user()->daftarBacaan()->detach($post->id);
        return back()->with('success', 'Dihapus dari daftar bacaan.');
    }
}
