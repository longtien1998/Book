<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('admin.comments.list', compact('comments') ,[
            'title' => 'Danh bình luận bình luận mới nhất',
            'comments' => $comments
        ]);
    }


    public function delete($id)
    {
        try {
            Comment::find($id)->delete();
            return redirect()->route('comments.list')->with('success', 'Xoá bình luận thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận thất bại.');
        }
    }
    public function list_trash_comments()

    {
        $comments = Comment::onlyTrashed()->paginate(15);
        return view('admin.comments.list-trash', compact('comments'));
    }

    public function delete_list_comments(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $comments = Comment::find($list);
                    $comments->deleted_at = now();
                    $comments->save();
                }
                return redirect()->route('comments.list')->with('success', 'Xoá bình luận thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn bình luận cần xóa!');
        }
    }

    public function restore_trash_comments(Request $request)
    {
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Comment::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục bình luận khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục bình luận khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn bình luận cần khôi phục!');
        }
    }

    public function delete_trash_comments(Request $request)
    {

        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Comment::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa bình luận khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn bình luận cần xóa khỏi thùng rác!');
        }
    }
    public function restore_all_comments()
    {
        try {
            Comment::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả bình luận khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục bình luận khỏi thùng rác thất bại.');
        }
    }
    public function destroy_trash_comments($id)
    {
        try {
            Comment::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('comments.trash.list')->with('success', 'Xóa bình luận khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bình luận khỏi thùng rác thất bại.');
        }
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required|string|min:1',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
            'search.min' => 'Từ khóa tìm kiếm phải có ít nhất 1 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $query = $request->input('search');
            $comments = Comment::with(['user', 'book']) // Sử dụng eager loading
                ->where(function($q) use ($query) {
                    $q->whereHas('user', function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('book', function($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%");
                    })
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhere('rating', 'LIKE', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.comments.list', [
                'comments' => $comments,
                'search' => $query
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tìm kiếm: ' . $e->getMessage());
        }
    }

    public function search_trash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required|string|min:1',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
            'search.min' => 'Từ khóa tìm kiếm phải có ít nhất 1 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $query = $request->input('search');
            $comments = Comment::onlyTrashed()
                ->with(['user', 'book'])
                ->where(function($q) use ($query) {
                    $q->whereHas('user', function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('book', function($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%");
                    })
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhere('rating', 'LIKE', "%{$query}%");
                })
                ->orderBy('deleted_at', 'desc')
                ->paginate(10);

            return view('admin.comments.list-trash', [
                'comments' => $comments,
                'search' => $query
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tìm kiếm: ' . $e->getMessage());
        }
    }
}
