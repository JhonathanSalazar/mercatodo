<?php

namespace App\Imports;

use App\Entities\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;
    use SkipsFailures;

    /**
     * @var int
     */
    private int $rows = 0;

    /**
     * @param array $row
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        ++$this->rows;

        return Product::updateOrCreate(
            [
                'ean' => $row['ean'],
            ],
            [
                'ean' => $row['ean'],
                'name' => $row['nombre'],
                'branch' => $row['marca'],
                'description' => $row['descripcion'],
                'category_id' => $row['id_categoria'],
                'price' => $row['precio'],
                'stock' => $row['stock'],
                'published_at' => $row['fecha_publicacion'],
                'user_id' => auth()->id(),
            ]
        );
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'ean' => 'required|integer|digits_between:8,14',
            'nombre' => 'required',
            'marca' => 'required',
            'descripcion' => 'required',
            'id_categoria' => 'required',
            'precio' => 'required|integer',
        ];
    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }

}
