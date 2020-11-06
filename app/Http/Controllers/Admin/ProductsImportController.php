<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductRequest;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductsImportController extends Controller
{
    public function import(ImportProductRequest $request)
    {
        $file = $request->file('productsImport');
        $import = new ProductsImport;
        $import->import($file);

        dd($import->errors());

        return redirect()->route('admin.products.index')
            ->with('status', 'Productos importados');
    }
}
