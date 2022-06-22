<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserProfileController
{
    /**
     * Show the user details.
     *
     * @return Request $request
     */
    public function show(Request $request)
    {
        return auth()->user();
    }

    /**
     * Update the users password.
     *
     * @param  Request          $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|confirmed|min:6',
        ]);

        if (! Hash::check($request->old_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Wrong password.',
            ]);
        }
        $request->user()->password = Hash::make($request->password);
        $request->user()->save();

        return $request->user();
    }
}
