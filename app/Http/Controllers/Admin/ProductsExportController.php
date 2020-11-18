<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Report;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class ProductsExportController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function export(): RedirectResponse
    {
        $user = auth()->user();
        $now = Carbon::now()->isoFormat('YYYY-MM-DD');
        $filePath = 'exports/products-' . $now . '.xlsx';

        (new ProductExport(auth()->user()))->store($filePath)
            ->chain([new NotifyUserOfCompletedExport($user, $filePath)]);

        return back()->with('status','Será notificado cuando el proceso termine');
    }

}
