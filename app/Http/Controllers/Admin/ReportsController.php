<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Report;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
