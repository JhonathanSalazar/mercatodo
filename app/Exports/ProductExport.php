<?php

namespace App\Exports;


use App\Entities\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductExport implements FromCollection,
    WithMapping,
    WithHeadings,
    WithColumnFormatting,
    ShouldQueue
{

    use Exportable;

    protected $authUser;

    public function __construct($authUser)
    {
        $this->authUser = $authUser;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Product::all();
    }

    /**
     * @return array
     * @var $product
     */
    public function map($product): array
    {
        return [
            $product->ean,
            $product->name,
            $product->branch,
            $product->description,
            $product->category->name,
            $product->price,
            $product->stock,
            $product->published_at->toDateString()
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'EAN',
            'NOMBRE',
            'MARCA',
            'DESCRIPCION',
            'CATEGORIA',
            'PRECIO',
            'STOCK',
            'FECHA_PUBLICACION',
        ];
    }
}
