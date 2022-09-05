<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\SystemUserIndex;
use Admin\Http\Resources\StoredResource;
use Admin\Http\Resources\SystemUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SystemUserController
{
    /**
     * User index page.
     *
     * @param  Request   $request
     * @param  UserIndex $index
     * @return UserIndex
     */
    public function index(Request $request, SystemUserIndex $index)
    {
        return $index->items(
            request: $request,
            query: User::query(),
            resource: SystemUserResource::class
        );
    }

    /**
     * Update the given system user.
     *
     * @param  Request $request
     * @param  User    $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email',
            'password' => 'sometimes|string',
            'is_admin' => 'required|boolean',
        ]);

        $user->update($validated);
    }

    /**
     * Create a new system user.
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email',
            'password' => 'required|string',
            'is_admin' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::make($validated);

        $user->save();

        return new StoredResource($user);
    }

    /**
     * Show the given user.
     *
     * @param  Request            $request
     * @param  User               $user
     * @return SystemUserResource
     */
    public function show(Request $request, User $user)
    {
        return new SystemUserResource($user);
    }

    /**
     * Delete a given user.
     *
     * @param  Request  $request
     * @param  User     $user
     * @return Response
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
