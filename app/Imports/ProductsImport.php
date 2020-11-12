<?php

namespace App\Imports;

use App\Concerns\HasProductValidationRules;
use App\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    use HasProductValidationRules;

    /**
     * @param array $row
     * @return Model|Model[]|null
     */
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
}
