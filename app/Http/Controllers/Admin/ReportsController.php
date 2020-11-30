<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Report;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
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
            'role:Super|Admin'
        ]);
    }

    /**
     * Report index view.
     *
     * @return View
     */
    public function index(): View
    {
        $reports = Report::all();

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Download the specific report.
     *
     * @param Report $report
     * @return StreamedResponse
     */
    public function download(Report $report): StreamedResponse
    {
        return Storage::download($report->file_path);
    }

    /**
     * @param Report $report
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Report $report): RedirectResponse
    {
        Storage::delete($report->file_path);

        $report->delete();

        return back()->with('status', 'Su reporte a sido eliminado');
    }

}
