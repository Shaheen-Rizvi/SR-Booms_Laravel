<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

// Add these imports
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure your User model is imported

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // --- THE CRITICAL ADDITION START ---

        Fortify::authenticateUsing(function (Request $request) {
            // Validate input just like in your AuthController, or rely on AuthController to validate
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Make an HTTP request to your API login endpoint
            // Ensure config('app.url') is set correctly in your .env (e.g., APP_URL=http://127.0.0.1:8000)
            // Or use a specific API URL if you have one: config('app.api_url')
            $response = Http::post(config('app.url') . '/api/login', [
                'email' => $request->email,
                'password' => $request->password,
                // Do NOT send user_type here unless your AuthController expects it for login logic
                // The user_type is determined after successful login
            ]);

            // Check if the API login was successful (status 200 OK)
            if ($response->successful()) {
                $apiResponse = $response->json();

                // Ensure the API returned a user and token as expected
                if (isset($apiResponse['user']) && isset($apiResponse['token'])) {
                    $userData = $apiResponse['user'];
                    $token = $apiResponse['token'];

                    // Find the user in your local database using the ID from the API response
                    $user = User::find($userData['id']);

                    if ($user) {
                        // Log the user into Laravel's session
                        Auth::login($user, $request->boolean('remember'));

                        // Store the API token in the session for later use by web routes
                        session(['api_token' => $token]);

                        // Return the user instance to Fortify
                        return $user;
                    }
                }
            }

            return null;
        });

       
    }
}