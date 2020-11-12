<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductRequest;
use App\Imports\ProductsImport;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class ProductsImportController extends Controller
{
    /**
     * @param ImportProductRequest $request
     * @return RedirectResponse
     */
    public function import(ImportProductRequest $request): RedirectResponse
    {
        $file = $request->file('productsImport');
        $import = new ProductsImport;
        $import->import($file);

        return redirect()->route('admin.products.index')
            ->with('status', 'Productos importados satisfactoriamente');
    }
}
