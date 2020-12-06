<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Product;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class ProductsExportController extends Controller
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
     * Export the resource.
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function export(): RedirectResponse
    {
        $this->authorize('export', Product::class);

        $user = auth()->user();
        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm');
        $filePath = 'exports/products-' . $now . '.xlsx';

        (new ProductExport(auth()->user()))->store($filePath)
            ->chain([new NotifyUserOfCompletedExport($user, $filePath)]);

        return back()->with('status','Será notificado cuando el proceso termine');
    }

}
