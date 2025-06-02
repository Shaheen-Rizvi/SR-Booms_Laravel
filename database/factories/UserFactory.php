<?php

namespace Database\Factories;

use App\Models\Team; // Keep if you use Jetstream Teams
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features; // Keep if you use Jetstream Features

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'user_type' => fake()->randomElement(['user', 'admin']), // Your user_type field
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // This line is correct for hashing
            'two_factor_secret' => null, // Keep if using Jetstream's 2FA
            'two_factor_recovery_codes' => null, // Keep if using Jetstream's 2FA
            'remember_token' => Str::random(10),
            'profile_photo_path' => null, // Keep if using profile photos
            'current_team_id' => null, // Keep if using Jetstream Teams
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}