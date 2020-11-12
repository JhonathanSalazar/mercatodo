<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductRequest;
use App\Imports\ProductsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ProductsImportController extends Controller
{
    /**
     * @param ImportProductRequest $request
     * @return RedirectResponse|Response
     */
    public function import(ImportProductRequest $request)
    {
        $file = $request->file('productsImport');
        $import = new ProductsImport;
        $import->import($file);
        $cant = $import->getRowCount();

        if (count($import->failures()) > 0) {
            $failures = $this->displayError($import->failures());
            return response()->view('admin.products.import.errors', [
                'failures' => $failures,
                'cant' => $cant
            ]);
        } else {
            return redirect()->route('admin.products.index')
                ->with('status', "Se importarón $cant registros satisfactoriamente");
        }

    }

    /**
     * Show the import error in a admin view.
     *
     * @param $failures
     */
    private function displayError($failures)
    {

        $validationError = [];

        foreach ($failures as $failure) {
            $validationError[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'error' => $failure->errors(),
                'values' =>  $failure->values()
            ];
        }

        return $validationError;
    }
}
