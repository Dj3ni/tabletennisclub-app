<?php

declare(strict_types=1);

use App\Models\ClubAdmin\Users\User;
use App\Models\ClubEvents\Interclub\Club;
use App\Providers\RouteServiceProvider;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

describe('User Registration', function () {
    beforeEach(function () {
        // We ensure the Club exist
        Club::create([
            'name' => 'Mon Club Test',
            'licence' => config('app.club_licence'),
            'street' => config('app.street'),
            'city_code' => config('app.city_code'),
            'city_name' => config('app.city_name'),
        ]);
    });

    it('renders the registration screen', function () {
        get('/register')
            ->assertOk()
            ->assertViewIs('clubAdmin.users.auth.register');
    });

    it('registers new users successfully', function () {
        $this->withoutExceptionHandling();
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = post('/register', $userData);

        $response->assertRedirect(RouteServiceProvider::HOME);
        assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        assertAuthenticatedAs($user);

        // Check associated to the club
        expect($user->club)->not->toBeNull()
            ->and($user->club->licence)->toBe(config('app.club_licence'));
    });

    it('requires valid data to register', function (string $field, $value) {
        post('/register', [$field => $value])
            ->assertSessionHasErrors($field);
    })->with([
        'missing first name' => ['first_name', ''],
        'invalid email' => ['email', 'not-an-email'],
        'short password' => ['password', '123'],
    ]);

})->group('auth', 'user');
