<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Pastikan path view sesuai dengan struktur folder Anda
        return view('pages.dashboard'); // atau 'pages.admin.dashboard' jika ada subfolder "admin"
    }
}
