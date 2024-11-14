<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::paginate(15);
        return view('admin.categories.list', compact('categories'));
    }
    public function create()
    {
        return view('admin.categories.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ], [
            'name.required' => 'Tên thể loại không được để trống.',
        ]);
        $category = new Categories();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        if ($category->save()) {
            return redirect()->route('categories.list')->with('success', 'Thêm mới thể loại thành công');
        } else {
            return redirect()->back()->with('error', 'Thêm mới thể loại thất bại');
        }
    }
    public function edit($id)
    {
        $category = Categories::find($id);
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ], [
            'name.required' => 'Tên thể loại không được để trống.',
        ]);
        $category = Categories::find($id);

        if ($category) {
            $category->name = $request->input('name');
            $category->description = $request->input('description');

            if ($category->save()) {
                return redirect()->route('categories.list')->with('success', 'Cập nhật thể loại thành công');
            } else {
                return redirect()->back()->with('error', 'Cập nhật thể loại thất bại');
            }
        } else {
            return redirect()->route('categories.list')->with('error', 'Không tìm thấy thể loại');
        }

    }
    public function delete($id)
    {
        try {
            Categories::find($id)->delete();
            return redirect()->route('categories.list')->with('success', 'Xoá thể loại thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa thể loại thất bại.');
        }
    }
    public function list_trash_categories()

    {
        $categories = Categories::onlyTrashed()->paginate(15);
        return view('admin.categories.list-trash', compact('categories'));
    }

    public function delete_list_categories(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $categories = Categories::find($list);
                    $categories->deleted_at = now();
                    $categories->save();
                }
                return redirect()->route('categories.list')->with('success', 'Xoá thể loại thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa thể loại thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn thể loại cần xóa!');
        }
    }

    public function restore_trash_categories(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Categories::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục thể loại khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục thể loại khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn thể loại cần khôi phục!');
        }
    }

    public function delete_trash_categories(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Categories::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa thể loại khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa thể loại khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn thể loại cần xóa khỏi thùng rác!');
        }
    }
    public function restore_all_categories()
    {
        try {
            Categories::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả thể loại khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục thể loại khỏi thùng rác thất bại.');
        }
    }
    public function destroy_trash_categories($id)
    {
        try {
            Categories::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('categories.trash.list')->with('success', 'Xóa thể loại khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa thể loại khỏi thùng rác thất bại.');
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
            $categories = Categories::search($query);
            if ($categories->isEmpty()) {
                return redirect()->route('categories.list')->with('error', 'Không tìm thấy thể loại nào phù hợp với từ khóa');

            } else {

                return view('admin.categories.list', compact('categories'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy thể loại nào phù hợp với từ khóa.');
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
            $categories = Categories::onlyTrashed()
            ->where('name','LIKE', '%' . $query . '%')
            ->orWhere('description','LIKE', '%' . $query . '%')
            ->paginate(10);
            if ($categories->isEmpty()) {
                return redirect()->route('categories.trash.list')->with('error', 'Không tìm thấy thể loại nào phù hợp với từ khóa');
            } else {
                return view('admin.categories.list-trash', compact('categories'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy thể loại nào phù hợp với từ khóa.');
        }
    }
}
