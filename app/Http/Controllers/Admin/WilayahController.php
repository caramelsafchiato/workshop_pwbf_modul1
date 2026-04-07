<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function indexAjax()
    {
        return view('admin.wilayah.ajax');
    }

    public function indexAxios()
    {
        return view('admin.wilayah.axios');
    } 
}