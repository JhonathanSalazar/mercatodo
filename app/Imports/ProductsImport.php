<?php

namespace App\Imports;

use App\Entities\ErrorImport;
use App\Entities\Product;
use App\Jobs\NotifyUserIncompletedImport;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;

class ProductsImport implements ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    WithChunkReading,
    WithUpserts,
    ShouldQueue

{
    use Importable;
    use SkipsFailures;

    /**
     * ProductsImport constructor.
     *
     */
    public function __construct()
    {

    }

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

        /*
        $categoryName = $row['categoria'];
        $category = Category::firstOrCreate([
            'name' => $categoryName,
            'url' => Str::slug($categoryName)
        ]);
         */

        return new Product([
            'ean' => $row['ean'],
            'name' => $row['nombre'],
            'branch' => $row['marca'],
            'description' => $row['descripcion'],
            'category_id' => 1,
            'price' => $row['precio'],
            'stock' => $row['stock'],
            'published_at' => Carbon::create($row['fecha_publicacion']),
            'user_id' => 1,
        ]);

        /*
        Product::firstOrCreate(
            [
                'ean' => $row['ean'],
            ],
            [
                'ean' => $row['ean'],
                'name' => $row['nombre'],
                'branch' => $row['marca'],
                'description' => $row['descripcion'],
                'category_id' => $category->id,
                'price' => $row['precio'],
                'stock' => $row['stock'],
                'published_at' => Carbon::create($row['fecha_publicacion']),
                'user_id' => auth()->id(),
            ]
        );
        */
    }

    /**
     * Validations to import products.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'ean' => 'required|integer|digits_between:8,14',
            'nombre' => 'required',
            'marca' => 'required',
            'descripcion' => 'required',
            'categoria' => 'required',
            'precio' => 'required|integer',
        ];
    }

    /**
     * Get the row count.
     *
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 10000;
    }

    /**
     * Assert to upsert the model.
     *
     * @return string
     */
    public function uniqueBy(): string
    {
        return 'ean';
    }

    /**
     * Handlers the failures of import process.
     *
     * @param Failure ...$failures
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            ErrorImport::create([
                'import' => trans('fields.products'),
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'value' => implode(', ', $failure->values()),
                'errors' => implode(', ', $failure->errors()),
            ]);
        }
    }
}
