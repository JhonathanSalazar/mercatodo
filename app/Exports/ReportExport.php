<?php

namespace App\Exports;

use App\Constants\Reports;
use App\Entities\Order;
use App\Entities\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportExport implements
    FromCollection,
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
     * Return the collection required to create the report.
     *
     * @return Collection
     */
    public function collection(): Collection
    {
        $values = [];

        switch ($this->type) {
            case Reports::SOLD_PRODUCTS:
                $values = Order::soldProducts($this->fromDate, $this->untilDate)->get();
                break;
            case Reports::ORDERS_CREATED:
                $values = Order::createdBetween($this->fromDate, $this->untilDate)->get();
        }

        return $values;
    }

    /**
     * Map the values to respective columns.
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        $columns = [];

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
                break;
            case Reports::ORDERS_CREATED:
                $columns = [
                    $row->order_reference,
                    $row->user_id,
                    $row->grand_total,
                    $row->item_count,
                    $row->status,
                    $row->created_at
                ];
                break;
        }

        return $columns;
    }

    /**
     * Name the respective columns.
     *
     * @return array
     */
    public function headings(): array
    {
        $heading = [];

        switch ($this->type) {
            case Reports::SOLD_PRODUCTS:

                $heading = [
                    trans('reports.order_reference'),
                    trans('reports.ean'),
                    trans('reports.product_name'),
                    trans('reports.product_price'),
                    trans('reports.paid_at'),
                    trans('reports.buyer_user_id'),
                ];

                break;
            case Reports::ORDERS_CREATED:

                $heading = [
                    trans('reports.order_reference'),
                    trans('reports.buyer_user_id'),
                    trans('reports.grand_total'),
                    trans('reports.item_count'),
                    trans('reports.status'),
                    trans('reports.created_at'),
                ];

                break;
        }

        return $heading;
    }
}
