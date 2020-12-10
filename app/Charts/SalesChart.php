<?php

declare(strict_types=1);

namespace App\Charts;

use App\Entities\Order;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SalesChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     * @param Request $request
     * @return Chartisan
     */
    public function handler(Request $request): Chartisan
    {
        $orderPayed = Order::PayedPerDayToChart()
            ->map(function ($group) {
                return $group->sum('grand_total');
            })->all();

        $dates = array_keys($orderPayed);
        $total = array_values($orderPayed);

        return Chartisan::build()
            ->labels($dates)
            ->dataset('Sample', $total);
    }
}
