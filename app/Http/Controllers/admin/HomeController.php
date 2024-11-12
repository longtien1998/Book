<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    public function fontawesome(){
        return view('admin.fontawesome');
    }
    public function basic_table(){
        return view('admin.basic-table');
    }
}
