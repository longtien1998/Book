<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.list', compact('users'));
    }

    public function create()
    {
        return view('admin.users.add', [
            'title' => 'Thêm tài khoản mới',

        ]);
    }
    public function store(CreateUserRequest $request)
    {
        $result = $this->userService->create($request);
        if ($result) {
            return redirect()->route('users.list');
        }
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $user = $this->userService->findUserById($id);
        return view('admin.users.edit', [
            'title' => 'Chỉnh sửa tài khoản: ' . $user->name,
            'user' => $user,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->userService->update($request, $id);

        if ($result) {
            return redirect()->route('users.list');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        try {
            User::find($id)->delete();
            return redirect()->route('users.list')->with('success', 'Xoá tài khoản thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa tài khoản thất bại.');
        }
    }
    public function list_trash_users()
    {
        $users = $this->userService->getTrashedUsers();
        return view('admin.users.list-trash', compact('users'));
    }

    public function delete_list_users(Request $request)
    {
        $deletelist = json_decode($request->delete_list, true);
        if (is_array($deletelist)) {
            $result = $this->userService->deleteUsersList($deletelist);
            if ($result['status']) {
                return redirect()->route('users.list')->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message']);
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn tài khoản cần xóa!');
        }
    }

    public function restore_trash_users(Request $request)
    {
        $restoreList = json_decode($request->restore_list, true);
        if (is_array($restoreList)) {
            $result = $this->userService->restoreUsersList($restoreList);
            if ($result['status']) {
                return redirect()->route('users.list')->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message']);
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn tài khoản cần khôi phục!');
        }
    }

    public function delete_trash_users(Request $request)
    {
        $deleteList = json_decode($request->delete_list, true);
        if (is_array($deleteList)) {
            $result = $this->userService->forceDeleteUsersList($deleteList);
            if ($result['status']) {
                return redirect()->back()->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message']);
            }
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn tài khoản cần xóa khỏi thùng rác!');
        }
    }

    public function restore_all_users()
    {
        $result = $this->userService->restoreAllUsers();
        if ($result['status']) {
            return redirect()->route('users.list')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    public function destroy_trash_users($id)
    {
        $result = $this->userService->forceDeleteUser($id);
        if ($result['status']) {
            return redirect()->route('users.trash.list')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    // Tìm kiếm người dùng
    public function search(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);

        if ($validate->fails()) {
            return redirect()->route('users.list')
                            ->withErrors($validate)
                            ->withInput();
        }

        try {
            $query = $request->search;
            $users = User::where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%')
                        ->orWhere('role', 'LIKE', '%' . $query . '%')
                        ->paginate(10); // Phân trang

            if ($users->isEmpty()) {
                return redirect()->route('users.list')->with('error', 'Không tìm thấy tài khoản nào phù hợp với từ khóa');
            } else {
                return view('admin.users.list', compact('users'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy tài khoản nào phù hợp với từ khóa.');
        }
    }

    // Tìm kiếm người dùng đã xóa mềm
    public function search_trash(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'search' => 'required|string',
        ], [
            'search.required' => 'Vui lòng nhập từ khóa tìm kiếm',
            'search.string' => 'Từ khóa tìm kiếm phải là chuỗi',
        ]);

        if ($validate->fails()) {
            return redirect()->route('users.trash.list')
                            ->withErrors($validate)
                            ->withInput();
        }

        try {
            $query = $request->search;
            $users = User::onlyTrashed()
                        ->where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%')
                        ->orWhere('role', 'LIKE', '%' . $query . '%')
                        ->paginate(10); // Phân trang

            if ($users->isEmpty()) {
                return redirect()->route('users.trash.list')->with('error', 'Không tìm thấy tài khoản nào phù hợp với từ khóa');
            } else {
                return view('admin.users.list-trash', compact('users'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy tài khoản nào phù hợp với từ khóa.');
        }
    }

}
