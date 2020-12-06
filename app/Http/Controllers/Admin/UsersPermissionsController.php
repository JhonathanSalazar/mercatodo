<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UsersPermissionsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->syncPermissions($request->permissions);

        return back()->with('status', 'Los permisos han sido actualizado');
    }
}
