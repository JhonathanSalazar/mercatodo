<?php

namespace App\Imports;

use App\Entities\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ProductsImport implements ToModel, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsErrors;

    public function model(array $row)
    {
        return Product::updateOrCreate(
            [
                'name'      => $row['nombre'],
                'branch'    => $row['marca']
            ],
            [
                'ean'           => $row['ean'],
                'name'          => $row['nombre'],
                'branch'        => $row['marca'],
                'description'   => $row['descripcion'],
                'category_id'   => $row['id_categoria'],
                'price'         => $row['precio'],
                'stock'         => $row['stock'],
                'published_at'  => $row['fecha_publicacion'],
                'user_id'       => auth()->id(),
            ]
        );
    }

    public function onFailure(Failure ...$failures)
    {
        // TODO: Implement onFailure() method.
    }
}
