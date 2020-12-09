<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductRequest;
use App\Imports\ProductsImport;
use App\Jobs\DeleteErrorsImportsTable;
use App\Jobs\NotifyUserCompletedImport;
use App\Jobs\NotifyUserIncompletedImport;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function import(ImportProductRequest $request): RedirectResponse
    {
        $this->authorize('import', Product::class);

        (new ProductsImport())->queue($request->file('productsImport'))
            ->chain([
                new NotifyUserCompletedImport($request->user()),
                new DeleteErrorsImportsTable(),
            ]);

        return redirect(route('admin.products.index'));
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

}
