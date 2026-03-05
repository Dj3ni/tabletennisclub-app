<?php

declare(strict_types=1);

use App\Models\ClubEvents\Tournament\Tournament;
use App\Support\Breadcrumb;
use Illuminate\Support\Facades\Route;

describe('Breadcrumb', function (): void {
    it('can be instantiated using make method', function (): void {
        $breadcrumb = Breadcrumb::make();

        expect($breadcrumb)->toBeInstanceOf(Breadcrumb::class);
    });

    it('starts with empty items array', function (): void {
        $breadcrumb = Breadcrumb::make();

        expect($breadcrumb->toArray())->toBe([]);
    });

    describe('translated methods', function (): void {
        it('translates breadcrumbs in French', function (string $english, string $french): void {
            // On force la langue en français pour ce test
            app()->setLocale('fr_BE');

            // Simulation de la route
            Route::get('/seasons', fn () => 'ok')->name('clubEvents.interclubs.seasons.index');

            $breadcrumb = Breadcrumb::make()->seasons();
            $items = $breadcrumb->toArray();

            expect($items[0]['title'])->toBe($french);
        })->with([
            ['Seasons', 'Saisons'],

        ]);
    });

    describe('add method', function (): void {

        it('adds basic breadcrumbs with default routes', function (string $method, string $title, string $routeName) {
            Route::get("/{$routeName}", fn () => $title)->name("{$routeName}.index");

            $breadcrumb = Breadcrumb::make()->{$method}();
            $items = $breadcrumb->toArray();

            expect($items[0]['title'])->toBe($title)
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

    describe('home method', function (): void {
        it('adds home breadcrumb with default route', function (): void {
            Route::get('/dashboard', fn () => 'dashboard')->name('dashboard');

            $breadcrumb = Breadcrumb::make()->home();
            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(1)
                ->and($items[0]['title'])->toBe('Admin')
                ->and($items[0]['icon'])->toBe('home')
                ->and($items[0]['url'])->toContain('/dashboard');
        });

        it('adds home breadcrumb with custom url', function (): void {
            $breadcrumb = Breadcrumb::make()->home('/custom-home');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Admin', 'url' => '/custom-home', 'icon' => 'home'],
            ]);
        });

        it('returns self for method chaining', function (): void {
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->home();

            expect($result)->toBe($breadcrumb);
        });
    });

    describe('tournaments method', function (): void {
        it('adds tournaments breadcrumb with default route', function (): void {
            Route::get('/tournaments', fn () => 'tournaments')->name('tournaments.index');

            $breadcrumb = Breadcrumb::make()->tournaments();
            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(1)
                ->and($items[0]['title'])->toBe('Tournaments')
                ->and($items[0]['icon'])->toBeNull()
                ->and($items[0]['url'])->toContain('/tournaments');
        });

        it('adds tournaments breadcrumb with custom url', function (): void {
            $breadcrumb = Breadcrumb::make()->tournaments('/custom-tournaments');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Tournaments', 'url' => '/custom-tournaments', 'icon' => null],
            ]);
        });

        it('returns self for method chaining', function (): void {
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->tournaments();

            expect($result)->toBe($breadcrumb);
        });
    });

    describe('users method', function (): void {
        it('adds users breadcrumb with default route', function (): void {
            Route::get('/users', fn () => 'users')->name('users.index');

            $breadcrumb = Breadcrumb::make()->users();
            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(1)
                ->and($items[0]['title'])->toBe('Users')
                ->and($items[0]['icon'])->toBeNull()
                ->and($items[0]['url'])->toContain('/users');
        });

        it('adds users breadcrumb with custom url', function (): void {
            $breadcrumb = Breadcrumb::make()->users('/custom-users');

            expect($breadcrumb->toArray())->toBe([
                ['title' => 'Users', 'url' => '/custom-users', 'icon' => null],
            ]);
        });

        it('returns self for method chaining', function (): void {
            $breadcrumb = Breadcrumb::make();
            $result = $breadcrumb->users();

            expect($result)->toBe($breadcrumb);
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
                ->and($items[1]['title'])->toBe('Tournaments')
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
                ->and($items[1]['title'])->toBe('Users')
                ->and($items[2]['title'])->toBe('Create User')
                ->and($items[2]['url'])->toBeNull();
        });

        it('can mix predefined and custom breadcrumbs', function (): void {
            Route::get('/dashboard', fn () => 'dashboard')->name('dashboard');

            $breadcrumb = Breadcrumb::make()
                ->home()
                ->add('Settings', '/settings', 'cog')
                ->current('Profile');

            $items = $breadcrumb->toArray();

            expect($items)->toHaveCount(3)
                ->and($items[0]['title'])->toBe('Admin')
                ->and($items[1]['title'])->toBe('Settings')
                ->and($items[1]['url'])->toBe('/settings')
                ->and($items[1]['icon'])->toBe('cog')
                ->and($items[2]['title'])->toBe('Profile')
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
