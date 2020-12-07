<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Permissions;
use App\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductRequest;
use App\Imports\ProductsImport;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductsImportController extends Controller
{

    /**
     * File import template.
     *
     * @var string
     */
    private string $templateFile = 'imports/product-import-template.xlsx';

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
     * Import the resources.
     *
     * @param ImportProductRequest $request
     * @return RedirectResponse|Response
     * @throws AuthorizationException
     */
    public function import(ImportProductRequest $request)
    {
        $this->authorize('import', Product::class);

        $file = $request->file('productsImport');

        $import = new ProductsImport;
        $import->import($file);

        $cant = $import->getRowCount();

        if (count($import->failures()) > 0) {
            $failures = $this->getFailures($import->failures());
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
     * Download the template import file.
     *
     * @return StreamedResponse
     */
    public function template(): StreamedResponse
    {
        return Storage::download($this->templateFile);
    }

    /**
     * Show the import error in a admin view.
     *
     * @param $failures
     * @return array
     */
    private function getFailures($failures): array
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
