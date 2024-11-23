<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Categories;
use App\Http\Requests\BooksRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::paginate(15);
        return view('admin.books.list', compact('books'));
    }
    public function create()
    {
        $categories = Categories::all();
        return view('admin.books.add', compact('categories'));
    }
    public function store(BooksRequest $request)
    {
        $book = new Books();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->description = $request->description;
        $book->availability_status = $request->availability_status;
        $book->category_id = $request->category_id;
        $book->publication_year = $request->publication_year;
        $book->publisher = $request->publisher;
        $book->stock_quantity = $request->stock_quantity;
        $book->isbn = $request->isbn;
        $book->language = $request->language;
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = $file->getClientOriginalName();
            // $file->move(public_path('upload/books'), $filename);
            $book->image_url = $filename;
        }
        if ($book->save()) {
            $file->move(public_path('upload/books'), $filename);
            return redirect()->route('books.list')->with('success', 'Thêm mới sách thành công');
        } else {
            return redirect()->back()->with('error', 'Thêm mới sách thất bại');
        }
    }
    public function edit($id)
    {
        $books = Books::find($id);
        $categories = Categories::all();
        return view('admin.books.edit', compact('books', 'categories'));
    }
    public function update(BooksRequest $request, $id)
    {
        $books = Books::find($id);
        if ($books) {
            $books->title = $request->title;
            $books->author = $request->author;
            $books->price = $request->price;
            $books->description = $request->description;
            $books->availability_status = $request->availability_status;
            $books->category_id = $request->category_id;
            $books->publication_year = $request->publication_year;
            $books->publisher = $request->publisher;
            $books->stock_quantity = $request->stock_quantity;
            $books->isbn = $request->isbn;
            $books->language = $request->language;
            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $filename = $file->getClientOriginalName();
                // $file->move(public_path('upload/books'), $filename);
                $books->image_url = $filename;
            }
            if ($books->save()) {
                return redirect()->route('books.list')->with('success', 'Cập nhật sách thành công');
            } else {
                return redirect()->back()->with('error', 'Cập nhật sách thất bại');
            }
        } else {
            return redirect()->route('books.list')->with('error', 'Không tìm thấy sách');
        }
    }
    public function delete($id)
    {
        try {
            Books::find($id)->delete();
            return redirect()->route('books.list')->with('success', 'Xoá sách thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa sách thất bại.');
        }
    }
    public function list_trash_books()

    {
        $books = Books::onlyTrashed()->paginate(15);
        return view('admin.books.list-trash', compact('books'));
    }

    public function delete_list_books(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $books = Books::find($list);
                    $books->deleted_at = now();
                    $books->save();
                }
                return redirect()->route('books.list')->with('success', 'Xoá sách thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa sách thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn sách cần xóa!');
        }
    }

    public function restore_trash_books(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Books::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục sách khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục sách khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn sách cần khôi phục!');
        }
    }

    public function delete_trash_books(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Books::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa sách khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa sách khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn sách cần xóa khỏi thùng rác!');
        }
    }
    public function restore_all_books()
    {
        try {
            Books::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả sách khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục sách khỏi thùng rác thất bại.');
        }
    }
    public function destroy_trash_books($id)
    {
        try {
            Books::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('books.trash.list')->with('success', 'Xóa sách khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa sách khỏi thùng rác thất bại.');
        }
    }

    public function search(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate);
        }
        try {
            $query = $request->search;
            $books = Books::search($query);
            if ($books->isEmpty()) {
                return redirect()->route('books.list')->with('error', 'Không tìm thấy sách nào phù hợp với từ khóa');
            } else {

                return view('admin.books.list', compact('books'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy sách nào phù hợp với từ khóa.');
        }
    }
    public function search_trash(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate);
        }
        try {
            $query = $request->search;
            $books = Books::onlyTrashed()
                ->where('title', 'LIKE', '%' . $query . '%')
                ->paginate(10);
            if ($books->isEmpty()) {
                return redirect()->route('books.trash.list')->with('error', 'Không tìm thấy sách nào phù hợp với từ khóa');
            } else {
                return view('admin.books.list-trash', compact('books'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy sách nào phù hợp với từ khóa.');
        }
    }
}
