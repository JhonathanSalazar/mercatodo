<?php

namespace App\Http\Controllers\Admin;

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
        $now = Carbon::now()->isoFormat('YYYY-MM-DD');
        $filePath = 'exports/' . 'products-' . $now . '.xlsx';

        (new ProductExport(auth()->user()))->store($filePath)
            ->chain([new NotifyUserOfCompletedExport(auth()->user(), $filePath) ]);

        return back()->with('status','La lista de productos se ha descargado');
    }

}
