<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::all();
        if ($books->isEmpty()) {
            return response()->json(['message' => 'Không có sách nào'], 400);
        }
        return response()->json($books, 200);
    }

    // Lấy thông tin sách theo ID
    public function show($id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json(['message' => 'Không tìm thấy sách'], 404);
        }

        return response()->json($book, 200);
    }

    // Lấy sách theo thể loại
    public function filterByCategory($id)
    {
        $books = Books::where('category_id', $id)->get();

        if ($books->isEmpty()) {
            return response()->json(['message' => 'Không có sách nào trong thể loại này'], 404);
        }

        return response()->json($books, 200);
    }
    public function getStatisticData(){
        $data = Books::selectRaw('category_id, COUNT(*) as count')
        ->groupBy('category_id')
        ->get();
        return response()->json($data, 200);
    }
}
