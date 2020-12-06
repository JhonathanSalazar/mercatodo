<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
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
     * Show the application dashboard.
     * @return View
     */
    public function main(): View
    {


        return view('admin.dashboard');
    }
}
