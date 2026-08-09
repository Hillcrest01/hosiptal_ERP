<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        $totalPatients = Patient::count();
        $recentPatients = Patient::latest()->limit(5)->get();

        $data = [
            'totalPatients' => $totalPatients,
            'recentPatients' => $recentPatients,
        ];

        return view('dashboard.index')->with($data);
    }
}
