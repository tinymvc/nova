<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\AccountService;
use Spark\Facades\Auth;
use Spark\Fire\Fire;
use Spark\Http\Response;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        return Fire::render('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): Response
    {
        $user = Auth::user();

        if (!$user->fill($request->validated())->save()) {
            abort(500, 'Unable to save your profile.');
        }

        return Fire::navigate(route('profile.edit'))
            ->with('status', 'Your profile has been updated.');
    }

    public function password(PasswordUpdateRequest $request, AccountService $accounts): Response
    {
        $accounts->changePassword(Auth::user(), $request->validated());

        return Fire::navigate(route('profile.edit'))
            ->with('status', 'Your password has been updated.');
    }
}
