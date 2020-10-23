<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
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

        $users = Cache::remember('users.all', 300 ,function () {
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
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'enable' => 'required'
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('status', 'Perfil actualizado satisfactoriamente');
    }
}
