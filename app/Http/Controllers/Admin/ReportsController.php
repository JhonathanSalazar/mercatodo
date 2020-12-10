<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Reports;
use App\Entities\Order;
use App\Entities\Report;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Jobs\ExportReportCompleted;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportsController extends Controller
{

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
     * Report index view.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Report::class);

        $reports = Report::all();

        return view('admin.reports.index', compact('reports'));
    }


    /**
     * Generate and store the required report.
     *
     * @param ReportRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ReportRequest $request): RedirectResponse
    {
        $this->authorize('store', Report::class);

        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm');
        $type = $request->get('report_type');
        $fromDate = Carbon::parse($request->get('from_date'));
        $untilDate = Carbon::parse($request->get('until_date'));
        $filePath = 'exports/' . $type . '_' . $now . '.xlsx';

        (new ReportExport($request->user(), $type, $fromDate, $untilDate))->store($filePath)
            ->chain([new ExportReportCompleted($request->user(), $filePath, $type)]);

        return redirect()->back()->with('status', trans('reports.created'));
    }

    /**
     * Download the specific report.
     *
     * @param Report $report
     * @return StreamedResponse
     * @throws AuthorizationException
     */
    public function download(Report $report): StreamedResponse
    {
        $this->authorize('download', $report);

        return Storage::download($report->file_path);
    }

    /**
     * Delete the specific resource.
     *
     * @param Report $report
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Report $report): RedirectResponse
    {
        $this->authorize('delete', $report);

        Storage::delete($report->file_path);

        $report->delete();

        return back()->with('status', 'Su reporte a sido eliminado');
    }

}
