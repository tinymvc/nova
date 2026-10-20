<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\AccountService;
use Spark\Facades\Auth;
use Spark\Http\Response;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        return fire('profile.edit', [
            'user' => User::findOrFail(Auth::id()),
        ]);
    }

    public function update(ProfileUpdateRequest $request): Response
    {
        $user = User::findOrFail(Auth::id());

        if (!$user->fill($request->validated())->save()) {
            abort(500, 'Unable to save your profile.');
        }

        return fire()->navigate((string) route('profile.edit'))
            ->with('status', 'Your profile has been updated.');
    }

    public function password(PasswordUpdateRequest $request, AccountService $accounts): Response
    {
        $accounts->changePassword(User::findOrFail(Auth::id()), $request->validated());

        return fire()->navigate((string) route('profile.edit'))
            ->with('status', 'Your password has been updated.');
    }
}
