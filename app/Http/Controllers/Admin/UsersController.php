<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;


class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
     *
     * @return Illuminate\View\View
     */
    public function index(): View
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return Illuminate\View\View
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return Illuminate\View\View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return Illuminate\Http\RedirectResponse
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
