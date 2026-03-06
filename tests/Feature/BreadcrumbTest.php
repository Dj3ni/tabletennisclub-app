<?php

declare(strict_types=1);

use App\Models\ClubEvents\Tournament\Tournament;
use App\Support\Breadcrumb;
use Illuminate\Support\Facades\Route;

describe('Breadcrumb', function (): void {
    describe('Instance tests', function () {
        it('can be instantiated using make method', function (): void {
            $breadcrumb = Breadcrumb::make();

            expect($breadcrumb)->toBeInstanceOf(Breadcrumb::class);
        });

        it('starts with empty items array', function (): void {
            $breadcrumb = Breadcrumb::make();

            expect($breadcrumb->toArray())->toBe([]);
        });
    });

    // ─────────────────────────────────────────────────────────────
    // Features methods
    // ─────────────────────────────────────────────────────────────

    describe('Dataset breadcrumb and url structure', function (): void {
        it('allows overriding default URLs in predefined methods', function (string $method_name) {

            $url = '/custom-url';
            $items = Breadcrumb::make()->$method_name($url)->toArray();
            expect($items[0]['url'])->toBe($url);

        })->with([
            ['home'],
            ['contacts'],
            ['eventPosts'],
            ['newsPosts'],
            ['profile'],
            ['rooms'],
            ['tables'],
            ['teams'],
            ['tournaments'],
            ['seasons'],
            ['subscriptions'],
            ['trainings'],
            ['trainingPacks'],
            ['users'],
        ]);

        it('adds the correct structure for predefined methods', function (string $method, string $routeName, ?string $icon = null) {
            Route::get("/test-{$method}", fn () => 'ok')->name($routeName);

            $items = Breadcrumb::make()->{$method}()->toArray();

            expect($items[0])->toHaveKeys(['title', 'url', 'icon'])
                ->and($items[0]['url'])->toContain(route($routeName))
                ->and($items[0]['icon'])->toBe($icon);
        })->with([
            // [ 'method_name', 'route_name', 'icon' ]
            ['home', 'dashboard', 'home'],
            ['contacts', 'clubAdmin.contacts.index'],
            ['eventPosts', 'clubPosts.eventPosts.index', 'home'],
            ['newsPosts', 'clubPosts.newsPosts.index', 'home'],
            ['profile', 'profile.edit'],
            ['rooms', 'rooms.index'],
            ['tables', 'tables.index'],
            ['teams', 'teams.index'],
            ['tournaments', 'tournaments.index'],
            ['seasons', 'clubEvents.interclubs.seasons.index', 'calendar'],
            ['subscriptions', 'clubAdmin.subscriptions.index', 'calendar'],
            ['trainings', 'trainings.index'],
            ['trainingPacks', 'admin.trainingpacks.index'],
            ['users', 'users.index'],
        ]);
        it('returns self for method chaining', function (string $method): void {
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->$method();

            expect($result)->toBe($breadcrumb);
        })->with([
            ['home'],
            ['contacts'],
            ['eventPosts'],
            ['newsPosts'],
            ['profile'],
            ['rooms'],
            ['tables'],
            ['teams'],
            ['tournaments'],
            ['seasons'],
            ['subscriptions'],
            ['trainings'],
            ['trainingPacks'],
            ['users'],
        ]);
    });

    describe('translated methods', function (): void {
        it('translates breadcrumb titles in French', function (string $method, string $expectedFrench): void {

            app()->setLocale('fr_BE');
            $items = Breadcrumb::make()->{$method}()->toArray();
            expect($items[0]['title'])->toBe($expectedFrench);

        })->with([
            // [ 'method_name', 'expected translation' ]
            ['contacts', 'Contacts'],
            ['eventPosts', 'Événements'],
            ['newsPosts', 'Articles'],
            ['profile', 'Profil'],
            ['rooms', 'Salles'],
            ['tables', 'Tables'],
            ['teams', 'Équipes'],
            ['tournaments', 'Tournois'],
            ['seasons', 'Saisons'],
            ['subscriptions', 'Cotisations'],
            ['trainings', 'Entraînements'],
            ['trainingPacks', 'Packs d\'entraînements'],
            ['users', 'Utilisateurs'],
        ]);
    });

    // ─────────────────────────────────────────────────────────────
    // Specific methods
    // ─────────────────────────────────────────────────────────────

    describe('add method', function (): void {

        it('adds basic breadcrumbs with default routes', function (string $method, string $title, string $routeName) {
            Route::get("/{$routeName}", fn () => $title)->name("{$routeName}.index");

            $breadcrumb = Breadcrumb::make()->{$method}();
            $items = $breadcrumb->toArray();

            expect($items[0]['title'])->toBe($title === 'Admin' ? $title : __($title))
                ->and($items[0]['url'])->toContain("/{$routeName}");
        })->with([
            // [Method name, title for Breadcrumb, url contains ]
            'home method' => ['home', 'Admin', 'dashboard'],
            'users method' => ['users', 'Users', 'users'],
            'profile method' => ['profile', 'Profile', 'profile'],
            'contacts method' => ['contacts', 'Contacts', 'contacts'],
            'newsPosts method' => ['newsPosts', 'NewsPosts', 'newsPosts'],
            'eventPosts method' => ['eventPosts', 'EventPosts', 'eventPosts'],
            'rooms method' => ['rooms', 'Rooms', 'rooms'],
            'tables method' => ['tables', 'Tables', 'tables'],
            'subscriptions method' => ['subscriptions', 'Subscriptions', 'subscriptions'],
            'trainingPacks method' => ['trainingPacks', 'Training Packs', 'trainingpacks'],
            'trainings method' => ['trainings', 'Trainings', 'trainings'],
            'seasons method' => ['seasons', 'Seasons', 'seasons'],
            'interclubs method' => ['interclubs', 'Interclubs', 'interclubs'],
            'teams method' => ['teams', 'Teams', 'teams'],
            'tournaments method' => ['tournaments', 'Tournaments', 'tournaments'],
        ]);

        it('can add a basic item with title only', function (): void {
            $breadcrumb = Breadcrumb::make()->add('Test Title');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Test Title', 'url' => null, 'icon' => null],
            ]);
        });

        it('can add an item with title and url', function (): void {
            $breadcrumb = Breadcrumb::make()->add('Test Title', '/test-url');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Test Title', 'url' => '/test-url', 'icon' => null],
            ]);
        });

        it('can add an item with title, url, and icon', function (): void {
            $breadcrumb = Breadcrumb::make()->add('Test Title', '/test-url', 'test-icon');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Test Title', 'url' => '/test-url', 'icon' => 'test-icon'],
            ]);
        });

        it('returns self for method chaining', function (): void {
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->add('Test');

            expect($result)->toBe($breadcrumb);
        });

        it('can chain multiple add calls', function (): void {
            $breadcrumb = Breadcrumb::make()
                ->add('First', '/first')
                ->add('Second', '/second');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'First', 'url' => '/first', 'icon' => null],
                ['title' => 'Second', 'url' => '/second', 'icon' => null],
            ]);
        });
    });

    describe('tournament method', function (): void {
        beforeEach(function (): void {
            $this->tournament = Tournament::factory()->create([
                'name' => 'Championship 2024',
            ]);
        });
        it('adds tournament breadcrumb with tournament object', function (): void {
            Route::get('/tournaments/{tournament}', fn ($tournament) => 'tournament')->name('tournaments.show');

            $breadcrumb = Breadcrumb::make()->tournament($this->tournament);
            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(1)
                ->and($items[0]['title'])->toBe('Championship 2024')
                ->and($items[0]['icon'])->toBeNull()
                ->and($items[0]['url'])->toContain('/tournaments/' . $this->tournament->id);
        });

        it('returns self for method chaining', function (): void {
            Route::get('/tournaments/{tournament}', fn ($tournament) => 'tournament')->name('tournaments.show');
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->tournament($this->tournament);

            expect($result)->toBe($breadcrumb);
        });
    });

    describe('current method', function (): void {
        it('adds current page breadcrumb without url', function (): void {
            $breadcrumb = Breadcrumb::make()->current('Current Page');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Current Page', 'url' => null, 'icon' => null],
            ]);
        });

        it('returns self for method chaining', function (): void {
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->current('Test');

            expect($result)->toBe($breadcrumb);
        });
    });

    describe('complex breadcrumb chains', function (): void {
        it('can build a complete breadcrumb navigation', function (): void {
            // Define routes
            Route::get('/dashboard', fn () => 'dashboard')->name('dashboard');
            Route::get('/tournaments', fn () => 'tournaments')->name('tournaments.index');
            Route::get('/tournaments/{tournament}', fn ($tournament) => 'tournament')->name('tournaments.show');

            $tournament = Tournament::factory()->create([
                'name' => 'World Cup 2024',
            ]);

            $breadcrumb = Breadcrumb::make()
                ->home()
                ->tournaments()
                ->tournament($tournament)
                ->current('Edit');

            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(4)
                ->and($items[0]['title'])->toBe('Admin')
                ->and($items[0]['icon'])->toBe('home')
                ->and($items[1]['title'])->toBe(__('Tournaments'))
                ->and($items[2]['title'])->toBe('World Cup 2024')
                ->and($items[2]['url'])->toContain('/tournaments/' . $tournament->id)
                ->and($items[3]['title'])->toBe('Edit')
                ->and($items[3]['url'])->toBeNull();
        });

        it('can build user management breadcrumb', function (): void {
            Route::get('/dashboard', fn () => 'dashboard')->name('dashboard');
            Route::get('/users', fn () => 'users')->name('users.index');

            $breadcrumb = Breadcrumb::make()
                ->home()
                ->users()
                ->current('Create User');

            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(3)
                ->and($items[0]['title'])->toBe('Admin')
                ->and($items[1]['title'])->toBe(__('Users'))
                ->and($items[2]['title'])->toBe('Create User')
                ->and($items[2]['url'])->toBeNull();
        });

        it('can mix predefined and custom breadcrumbs', function (): void {
            Route::get('/dashboard', fn () => 'dashboard')->name('dashboard');

            $breadcrumb = Breadcrumb::make()
                ->home()
                ->add('Settings', '/settings', 'cog')
                ->current('Profil');

            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(3)
                ->and($items[0]['title'])->toBe('Admin')
                ->and($items[1]['title'])->toBe('Settings')
                ->and($items[1]['url'])->toBe('/settings')
                ->and($items[1]['icon'])->toBe('cog')
                ->and($items[2]['title'])->toBe(__('Profile'))
                ->and($items[2]['url'])->toBeNull();
        });
    });

    describe('edge cases', function (): void {

        it('handles empty string title', function (): void {
            $breadcrumb = Breadcrumb::make()->add('');

            expect($breadcrumb->toArray())->toBe([
                ['title' => '', 'url' => null, 'icon' => null],
            ]);
        });

        it('handles null values properly', function (): void {
            $breadcrumb = Breadcrumb::make()->add('Test');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Test', 'url' => null, 'icon' => null],
            ]);
        });

        it('handles tournament with special characters in name', function (): void {
            Route::get('/tournaments/{tournament}', fn ($tournament) => 'tournament')->name('tournaments.show');

            $tournament = Tournament::factory()->create([
                'name' => 'Tournament & Championship 2024',
            ]);

            $breadcrumb = Breadcrumb::make()->tournament($tournament);
            $items = $breadcrumb->toArray();

            expect($items[0]['title'])->toBe('Tournament & Championship 2024')
                ->and($items[0]['url'])->toContain('/tournaments/' . $tournament->id);
        });
    });

    describe('toArray method', function (): void {
        it('returns array representation of breadcrumbs', function (): void {
            $breadcrumb = Breadcrumb::make()
                ->add('First')
                ->add('Second', '/second');

            $result = $breadcrumb->toArray();

            expect($result)->toBeArray()
                ->and($result)->toHaveCount(2);
        });

        it('returns empty array when no items added', function (): void {
            $breadcrumb = Breadcrumb::make();

            expect($breadcrumb->toArray())->toBe([]);
        });
    });
});
