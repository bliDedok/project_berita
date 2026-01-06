<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Illuminate\Http\Request;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        auth()->logout();

        return redirect()->route('login')
            ->with('status', 'Akun berhasil dibuat. Silakan login.');
    }
}
