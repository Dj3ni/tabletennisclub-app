<?php

declare(strict_types=1);

namespace App\Http\Controllers\ClubAdmin\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClubAdmin\Users\RegisterUserRequest;
use App\Models\ClubAdmin\Users\User;
use App\Models\ClubEvents\Interclub\Club;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('clubAdmin.users.auth.register');
    }


    /**
     * @param RegisterUserRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::make([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->club()->associate(Club::firstWhere('licence', config('app.club_licence')));
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
