<?php

declare(strict_types=1);

use App\Http\Requests\ClubAdmin\Users\RegisterUserRequest;
use Illuminate\Support\Facades\Validator;

it('validates the registration rules', function (array $data, bool $shouldPass) {
    $request = new RegisterUserRequest;

    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBe($shouldPass);
})->with([
    'success' => [
        'data' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'aZ1&sK9!pQ2m',
            'password_confirmation' => 'aZ1&sK9!pQ2m',
        ],
        'shouldPass' => true,
    ],
    'fails if email is invalid' => [
        'data' => ['email' => 'not-an-email'],
        'shouldPass' => false,
    ],
    'fails if password is too short' => [
        'data' => ['password' => 'abc'],
        'shouldPass' => false,
    ],
    'fails if passwords do not match' => [
        'data' => [
            'password' => 'Password123!',
            'password_confirmation' => 'Different123!',
        ],
        'shouldPass' => false,
    ],
])->group('auth', 'user');
