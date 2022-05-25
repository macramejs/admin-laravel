<?php

namespace Admin\Http\Controllers;

use Admin\Ui\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserProfileController
{
    /**
     * Show the user profile page.
     *
     * @param  Page $page
     * @return Page
     */
    public function show(Page $page)
    {
        return $page->page('UserProfile/Show')->with('user', auth()->user());
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

        return redirect()->back();
    }
}
