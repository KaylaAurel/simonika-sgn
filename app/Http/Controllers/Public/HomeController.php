<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class HomeController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();

        return view('public.home', [
            'totalEmployees' => $totalEmployees,
        ]);
    }
}