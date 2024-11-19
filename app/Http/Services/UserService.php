<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function findUserById($id)
    {
        return User::find($id);
    }
    public function create($request)
    {
        try {
            $request->except('_token');
            User::create($request->all());

            Session::flash('success', 'Thêm tài khoản thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm tài khoản lỗi');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }
    public function update(Request $request, $id) {
        $user = User::find($id);
        try {
            $user->fill($request->only([
                'name',
                'email',
                'role',
                'address',
                'phone',
            ]));
            $user->save();
            Session::flash('success', 'Cập nhật tài khoản thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi xảy ra, vui lòng thử lại');
            Log::error($err->getMessage());
            return false;
        }
        return true;
    }

    public function getTrashedUsers()
    {
        return User::onlyTrashed()->paginate(15);
    }

    // Xóa người dùng (xóa mềm)
    public function deleteUsersList(array $userIds)
    {
        try {
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                $user->deleted_at = now();
                $user->save();
            }
            return ['status' => true, 'message' => 'Xoá tài khoản thành công!'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Xóa tài khoản thất bại.'];
        }
    }

    // Khôi phục người dùng từ thùng rác
    public function restoreUsersList(array $userIds)
    {
        try {
            foreach ($userIds as $userId) {
                User::withTrashed()->where('id', $userId)->restore();
            }
            return ['status' => true, 'message' => 'Khôi phục tài khoản khỏi thùng rác thành công!'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Khôi phục tài khoản thất bại.'];
        }
    }

    // Xóa vĩnh viễn người dùng khỏi thùng rác
    public function forceDeleteUsersList(array $userIds)
    {
        try {
            foreach ($userIds as $userId) {
                User::withTrashed()->where('id', $userId)->forceDelete();
            }
            return ['status' => true, 'message' => 'Xóa tài khoản khỏi thùng rác thành công!'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Xóa tài khoản khỏi thùng rác thất bại.'];
        }
    }

    // Khôi phục tất cả người dùng từ thùng rác
    public function restoreAllUsers()
    {
        try {
            $trashedUsers = User::onlyTrashed()->count();
            if ($trashedUsers == 0) {
                return ['status' => false, 'message' => 'Không có tài khoản nào cần khôi phục từ thùng rác.'];
            }

            User::withTrashed()->restore();

            return ['status' => true, 'message' => 'Khôi phục tất cả tài khoản khỏi thùng rác thành công!'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Khôi phục tất cả tài khoản thất bại.'];
        }
    }


    // Xóa vĩnh viễn người dùng từ thùng rác
    public function forceDeleteUser($id)
    {
        try {
            User::withTrashed()->where('id', $id)->forceDelete();
            return ['status' => true, 'message' => 'Xóa tài khoản khỏi thùng rác thành công!'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Xóa tài khoản khỏi thùng rác thất bại.'];
        }
    }
}
