<?php

namespace App\Exports;

use App\Constants\Reports;
use App\Entities\Order;
use App\Entities\Report;
use App\Entities\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportExport implements FromCollection,
    WithMapping,
    WithHeadings,
    ShouldQueue
{
    use Exportable;

    /**
     * @var User
     */
    public User $user;
    private string $type;
    private string $fromDate;
    private string $untilDate;

    public function __construct(User $user, string $type, string $fromDate, string $untilDate)
    {
        $this->user = $user;
        $this->type = $type;
        $this->fromDate = $fromDate;
        $this->untilDate = $untilDate;
    }

    /**
     * @return Builder
     */
    public function collection()
    {
        switch ($this->type) {
            case Reports::SOLD_PRODUCTS:
                $values = Order::soldProducts($this->fromDate, $this->untilDate)->get();
        }

        return $values;
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {

        switch ($this->type) {
            case Reports::SOLD_PRODUCTS:
                $columns = [
                    $row->order_reference,
                    $row->ean,
                    $row->name,
                    $row->price,
                    $row->paid_at,
                    $row->user_id
                ];
        }

        return $columns;
    }

    /**
     * @return array
     */
    public function headings(): array
    {

        switch ($this->type) {
            case Reports::SOLD_PRODUCTS:
                $heading = [
                    trans('reports.reference'),
                    trans('reports.ean'),
                    trans('reports.product_name'),
                    trans('reports.product_price'),
                    trans('reports.paid_at'),
                    trans('reports.buyer_user_id'),
                ];
        }

        return $heading;
    }
}
