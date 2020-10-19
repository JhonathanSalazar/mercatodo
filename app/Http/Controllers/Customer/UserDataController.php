<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

class UserDataController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'verified'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize('view', $user);

        return view('pages.userAccount', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $data = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
        ]);

        $user->update($data);

        return back()->with('status', 'Información actualizada');
    }
}
