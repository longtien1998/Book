<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        if ($categories->isEmpty()) {
            return response()->json(['message' => 'Không có thể loại nào'], 404);
        }
        return response()->json(['categories' => $categories], 200);
    }
    public function show($id){
        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Không tìm thấy thể loại'], 404);
            }
        return response()->json(['category' => $category], 200);
    }
}
