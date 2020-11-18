<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Report;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportsController extends Controller
{
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
     * Download the report.
     *
     * @param Report $report
     * @return StreamedResponse
     */
    public function download(Report $report): StreamedResponse
    {
        return Storage::download($report->file_path);
    }

}
