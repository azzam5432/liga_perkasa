<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $dataPeserta = Peserta::all();
        
        return view('admin.dashboard', compact('dataPeserta'));
    }
}
