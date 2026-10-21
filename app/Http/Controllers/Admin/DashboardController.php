<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\Training;
use App\Models\Award;
use App\Models\SalarySlip;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();

        $totalDocuments = EmployeeDocument::count();

        $totalTrainings = Training::count();

        $totalAwards = Award::count();

        $totalSalarySlips = SalarySlip::count();

        $recentEmployees = Employee::query()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view(
    'admin.dashboard.index',
    [
        'totalEmployees' => $totalEmployees,
        'totalDocuments' => $totalDocuments,
        'totalTrainings' => $totalTrainings,
        'totalAwards' => $totalAwards,
        'totalSalarySlips' => $totalSalarySlips,
        'recentEmployees' => $recentEmployees,
    ]
);
    }
}