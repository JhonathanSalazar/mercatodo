<?php

namespace App\Http\Controllers\Customer;

use App\Entities\User;
use App\Http\Requests\UserDataRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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

        Log::info('pages.userAccount', ['user', auth()->id()]);

        return view('pages.userAccount', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param UserDataRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UserDataRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->update();

        Log::info('pages.userAccount.update', ['user', auth()->id()]);

        return back()->with('status', 'Información actualizada');
    }
}
