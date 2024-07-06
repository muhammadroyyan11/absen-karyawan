<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class PanelAdminController extends Controller
{
    public function index()
    {
        $data = [
            'tes' => 'tes'
        ];
        return view('admin.dashboard', compact('data'));
    }
}
