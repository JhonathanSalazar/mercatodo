<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'role:Super|Admin'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        Log::info('admin.users.index', ['user', auth()->id()]);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::pluck('name', 'id');

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('edit', User::class);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->enable = $request->get('enable');
        $user->update();

        return redirect()->route('admin.users.index')
            ->with('status', 'Perfil actualizado satisfactoriamente');
    }
}
