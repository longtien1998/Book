<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Books;
use App\Models\Advertisement;
use App\Models\Categories;



class HomeController extends Controller
{
    public function index(){
        $totalUser = User::count();
        $totalBook = Books::count();
        $totalAds = Advertisement::count();
        $totalCategory = Categories::count();
        return view('admin.dashboard', compact('totalUser', 'totalBook', 'totalAds', 'totalCategory'));
    }
    public function fontawesome(){
        return view('admin.fontawesome');
    }
    public function basic_table(){
        return view('admin.basic-table');
    }
}
