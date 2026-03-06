<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\ClubEvents\Tournament\Tournament;

class Breadcrumb
{
    protected array $items = [];

    public static function make(): static
    {
        return new static;
    }

    public function add(string $title, ?string $url = null, ?string $icon = null): static
    {
        $this->items[] = compact('title', 'url', 'icon');

        return $this;
    }

    public function contacts(?string $url = null): static
    {
        return $this->add(__('Contacts'), $url ?: route('clubAdmin.contacts.index'));
    }

    public function current(string $title): static
    {
        return $this->add($title);
    }

    public function eventPosts(?string $url = null): static
    {
        return $this->add(__('EventPosts'), $url ?: route('clubPosts.eventPosts.index'), 'home');
    }

    public function home(?string $url = null): static
    {
        return $this->add('Admin', $url ?: route('dashboard'), 'home');
    }

    public function interclubs(?string $url = null): static
    {
        return $this->add(__('Interclubs'), $url ?: route('interclubs.index'), 'home');
    }

    public function newsPosts(?string $url = null): static
    {
        return $this->add(__('NewsPosts'), $url ?: route('clubPosts.newsPosts.index'), 'home');
    }

    public function profile(?string $url = null): static
    {
        return $this->add(__('Profile'), $url ?: route('profile.edit'));
    }

    public function rooms(?string $url = null): static
    {
        return $this->add(__('Rooms'), $url ?: route('rooms.index'));
    }

    public function seasons(?string $url = null): static
    {
        return $this->add(__('Seasons'), $url ?: route('clubEvents.interclubs.seasons.index'), 'calendar');
    }

    public function subscriptions(?string $url = null): static
    {
        return $this->add(__('Subscriptions'), $url ?: route('clubAdmin.subscriptions.index'), 'calendar');
    }

    public function tables(?string $url = null): static
    {
        return $this->add(__('Tables'), $url ?: route('tables.index'));
    }

    public function teams(?string $url = null): static
    {
        return $this->add(__('Teams'), $url ?: route('teams.index'));
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function tournament(Tournament $tournament): static
    {
        return $this->add($tournament->name, route('tournaments.show', $tournament));
    }

    public function tournaments(?string $url = null): static
    {
        return $this->add(__('Tournaments'), $url ?: route('tournaments.index'));
    }

    public function trainingPacks(?string $url = null): static
    {
        return $this->add(__('Training Packs'), $url ?: route('admin.trainingpacks.index'));
    }

    public function trainings(?string $url = null): static
    {
        return $this->add(__('Trainings'), $url ?: route('trainings.index'));
    }

    public function users(?string $url = null): static
    {
        return $this->add(__('Users'), $url ?: route('users.index'));
    }
}
