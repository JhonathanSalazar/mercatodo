<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $reports = Report::all();

        return view('admin.reports.index', compact('reports'));
    }

}
