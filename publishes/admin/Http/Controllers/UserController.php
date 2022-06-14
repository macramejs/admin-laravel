<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\UserIndex;
use Admin\Ui\Page;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    /**
     * Media index page.
     *
     * @param  Request   $request
     * @param  UserIndex $index
     * @return UserIndex
     */
    public function items(Request $request, UserIndex $index)
    {
        return $index->items(
            request: $request,
            query: User::query(),
        );
    }

    /**
     * Delete a given user.
     *
     * @param  Request          $request
     * @param  User             $user
     * @return RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->back();
    }
}
