<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboards.admin');
    }

    public function manager()
    {
        return view('dashboards.manager');
    }

    public function staff()
    {
        return view('dashboards.staff');
    }
}
