<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Requests\AdvertisementRequest;
use Illuminate\Support\Facades\Validator;


class AdvertisementController extends Controller
{

    public function index()
    {
        $advertisements = Advertisement::paginate(15);
        return view('admin.advertisement.list', compact('advertisements'));
    }


    public function create()
    {
        return view('admin.advertisement.add');
    }


    public function store(AdvertisementRequest $request)
    {
        $advertisement = new Advertisement();
        $advertisement->title = $request->title;
        $advertisement->description = $request->description;
        $advertisement->url = $request->url;
        $advertisement->start_date = $request->start_date;
        $advertisement->end_date = $request->end_date;
        $advertisement->is_active = $request->is_active;
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            // $file->move(public_path('upload/ads'), $filename);
            $advertisement->image_path = $filename;
        }
        if ($advertisement->save()) {
            $file->move(public_path('upload/ads'), $filename);
            return redirect()->route('advertisements.index')->with('success', 'Thêm quảng cáo thành công!');
        } else {
            return redirect()->back()->with('error', 'Thêm quảng cáo thất bại!');
        }
    }
    public function edit($id)
    {
        $advertisements = Advertisement::find($id);
        // dd($advertisements);
        return view('admin.advertisement.edit', compact('advertisements'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'image_path' => 'image|mimes:jpg,png,gif,jpeg|max:10000',
                'description' => 'nullable|string',
                'url' => 'nullable|url',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ],
            [
                'title.required' => 'Tên không được để trống',
                'title.max' => 'Tên không được quá 255 ký tự',
                'image_path.mimes' => 'Hình ảnh phải là file jpeg, jpg, gif hoặc png',
                'image_path.max' => 'Hình ảnh không được quá 10MB',
                'description.max' => 'Mô tả không được quá 255 ký tự',
                'url.url' => 'Đường dẫn không đúng định dạng',
                'start_date.required' => 'Ngày bắt đầu không được để trống',
                'start_date.date' => 'Ngày bắt đầu không đúng định dạng',
                'end_date.required' => 'Ngày kết thúc không được để trống',
                'end_date.date' => 'Ngày kết thúc không đúng định dạng',
                'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
            ]
        );


        $advertisement = Advertisement::find($id);


        $advertisement->title = $request->title;
        $advertisement->description = $request->description;
        $advertisement->url = $request->url;
        $advertisement->start_date = $request->start_date;
        $advertisement->end_date = $request->end_date;

        $advertisement->is_active = $request->is_active;


        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $advertisement->image_path = $filename;
            $file->move(public_path('upload/ads'), $filename);
        }

        // Lưu dữ liệu
        if ($advertisement->save()) {
            return redirect()->route('advertisements.index')->with('success', 'Cập nhật quảng cáo thành công!');
        } else {
            return redirect()->back()->with('error', 'Cập nhật quảng cáo thất bại!');
        }
    }
    public function delete($id)
    {
        try {
            Advertisement::find($id)->delete();
            return redirect()->route('advertisements.index')->with('success', 'Xoá quảng cáo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo thất bại.');
        }
    }
    public function list_trash_advertisement()

    {
        $advertisements = Advertisement::onlyTrashed()->paginate(15);
        return view('admin.advertisement.list-trash', compact('advertisements'));
    }

    public function delete_list_advertisement(Request $request)
    {
        // dd($request->delete_list);
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            try {
                foreach ($deletelist as $list) {
                    $advertisements = Advertisement::find($list);
                    $advertisements->deleted_at = now();
                    $advertisements->save();
                }
                return redirect()->route('advertisements.index')->with('success', 'Xoá quảng cáo thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo thất bại.');
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn quảng cáo cần xóa!');
        }
    }

    public function restore_trash_advertisement(Request $request)
    {
        // dd($request->restore_list);
        // Giải mã chuỗi JSON thành mảng
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            try {
                foreach ($restoreList as $restore) {
                    Advertisement::withTrashed()->where('id', $restore)->restore();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục quảng cáo khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Khôi phục quảng cáo khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn quảng cáo cần khôi phục!');
        }
    }

    public function delete_trash_advertisement(Request $request)
    {
        // dd($request->delete_list);
        // Giải mã chuỗi JSON thành mảng
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            try {
                foreach ($deleteList as $delete) {
                    Advertisement::withTrashed()->where('id', $delete)->forceDelete();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo khỏi thùng rác thất bại.');
            }
            return redirect()->back()->with('success', 'Xóa quảng cáo khỏi thùng rác thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn quảng cáo cần xóa khỏi thùng rác!');
        }
    }
    public function restore_all_advertisement()
    {
        try {
            Advertisement::withTrashed()->restore();
            return redirect()->back()->with('success', 'Khôi phục tất cả quảng cáo khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Khôi phục quảng cáo khỏi thùng rác thất bại.');
        }
    }
    public function destroy_trash_advertisement($id)
    {
        try {
            Advertisement::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('advertisement.trash.list')->with('success', 'Xóa quảng cáo khỏi thùng rác thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa quảng cáo khỏi thùng rác thất bại.');
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
            $advertisements = Advertisement::search($query);
            if ($advertisements->isEmpty()) {
                return redirect()->route('advertisements.index')->with('error', 'Không tìm thấy quảng cáo nào phù hợp với từ khóa');
            } else {

                return view('admin.advertisement.list', compact('advertisements'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy quảng cáo nào phù hợp với từ khóa.');
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
            $advertisements = Advertisement::onlyTrashed()
                ->where('title', 'LIKE', '%' . $query . '%')
                ->paginate(10);
            if ($advertisements->isEmpty()) {
                return redirect()->route('advertisements.trash.list')->with('error', 'Không tìm thấy quảng cáo nào phù hợp với từ khóa');
            } else {
                return view('admin.advertisement.list-trash', compact('advertisements'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy quảng cáo nào phù hợp với từ khóa.');
        }
    }
}
