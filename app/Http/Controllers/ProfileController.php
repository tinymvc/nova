<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Spark\Facades\Auth;
use Spark\Facades\Hash;
use Spark\Http\Request;
use Spark\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): Response
    {
        $user = \App\Models\User::find(Auth::id());
        if (!$user) {
            return back()->withErrors(['general' => 'User not found.']);
        }

        $user->name = $request->validated()->string('name');
        $user->username = $request->validated()->string('username');
        $user->email = $request->validated()->string('email');

        // Check if password change is requested
        if ($request->filled('password')) {
            $currentPassword = (string) $request->input('current_password');

            if (!$currentPassword || !Hash::verify($currentPassword, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'The provided current password does not match our records.'])
                    ->withInput();
            }

            $user->password = $request->validated()->string('password');
        }

        $user->save();

        return back()->with('status', 'Your profile details have been successfully updated.');
    }
}
