<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\ResetUserPassword;

use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);
    $this->app->singleton(UpdatesUserProfileInformation::class, UpdateUserProfileInformation::class);
    $this->app->singleton(UpdatesUserPasswords::class, UpdateUserPassword::class);
    $this->app->singleton(ResetsUserPasswords::class, ResetUserPassword::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    Fortify::loginView(fn () => view('auth.login'));
    Fortify::registerView(fn () => view('auth.register'));
    Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot-password'));
    Fortify::resetPasswordView(fn (Request $request) => view('auth.reset-password', ['request' => $request]));

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
