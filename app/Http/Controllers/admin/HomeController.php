<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Books;



class HomeController extends Controller
{
    public function index(){
        $totalUser = User::count();
        $totalBook = Books::count();
        return view('admin.dashboard', compact('totalUser', 'totalBook'));
    }
    public function fontawesome(){
        return view('admin.fontawesome');
    }
    public function basic_table(){
        return view('admin.basic-table');
    }
}
