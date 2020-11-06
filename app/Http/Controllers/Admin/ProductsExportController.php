<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductsExportController extends Controller
{
    /**
     * @param ProductExport $productExport
     * @return Response|BinaryFileResponse
     */
    public function export(ProductExport $productExport)
    {
        return $productExport->download('products.xlsx');
    }

}
