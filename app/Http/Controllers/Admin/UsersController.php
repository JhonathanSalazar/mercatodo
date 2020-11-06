<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Http\Requests\UserRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'role:Admin'
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        //Refactorizar no hacer cache a usuarios
        $users = Cache::remember('users.all', 60 ,function () {
            return User::query()
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->select('users.id', 'users.name', 'users.email', 'users.enable','roles.name as role_name')
                ->get();
        });

        Log::info('admin.users.index', ['user', auth()->id()]);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
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
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->enable = $request->get('enable');
        $user->update();

        return redirect()->route('admin.users.index')
            ->with('status', 'Perfil actualizado satisfactoriamente');
    }
}
