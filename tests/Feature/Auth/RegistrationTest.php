<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureEmailIsVerified;
use App\Models\ClubAdmin\Users\User;
use App\Models\ClubEvents\Interclub\Club;
use App\Providers\RouteServiceProvider;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

describe('User Registration', function () {
    beforeEach(function () {
        $testLicence = 'TEST12345';
        config(['app.club_licence' => $testLicence]);
        // We ensure the Club exist
        Club::create([
            'name' => 'Mon Club Test',
            'licence' => $testLicence,
            'street' => 'Rue du Test, 30',
            'city_code' => '1340',
            'city_name' => 'Ottignies',
        ]);
    });

    it('renders the registration screen', function () {
        get('/register')
            ->assertOk()
            ->assertViewIs('clubAdmin.users.auth.register');
    });

    it('registers new users successfully, redirects him and is linked to the correct club', function () {
        // TODO: Identify the middleware causing this test to fail (it's not $this->withoutMiddleware([RedirectIfAuthenticated::class]);)
        $this->withoutMiddleware([EnsureEmailIsVerified::class]);
        $this->withoutExceptionHandling();

        Event::fake();

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'aZ1&sK9!pQ2m',
            'password_confirmation' => 'aZ1&sK9!pQ2m',
        ];

        $response = post(route('register'), $userData);

        // Check redirected after storing User
        $response->assertStatus(302);
        $response->assertRedirect(RouteServiceProvider::HOME);

        // Check user stored
        $user = User::where('email', 'john@example.com')->first();
        expect($user)->not->toBeNull()
            ->and($user->first_name)->toBe('John')
            ->and($user->last_name)->toBe('Doe')
            ->and(Hash::check('aZ1&sK9!pQ2m', $user->password))->toBeTrue();

        // Check user is authenticated
        $user = User::where('email', 'john@example.com')->first();
        assertAuthenticatedAs($user);

        // Check user is associated to the club
        expect($user->club)->not->toBeNull()
            ->and($user->club->licence)->toBe(config('app.club_licence'));
    });

    it('requires valid data to register', function (string $field, $value) {
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();
        post(route('register'), [$field => $value])
            ->assertSessionHasErrors($field);
        expect(User::count())->toBe(0);
    })->with([
        'missing first name' => ['first_name', ''],
        'invalid email' => ['email', 'not-an-email'],
        'short password' => ['password', '123'],
    ]);

})->group('auth', 'user');
