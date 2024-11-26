<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserService
{
    /**
     * Tìm người dùng theo ID.
     */
    public function findUserById($id)
    {
        return User::find($id);
    }

    /**
     * Hàm lưu ảnh avatar.
     */
    private function saveAvatar($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/users'), $filename);
        return $filename;
    }

    /**
     * Hàm xóa avatar cũ.
     */
    private function deleteOldAvatar($avatarPath)
    {
        $filePath = public_path('upload/users/' . $avatarPath);
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath); // Xóa file
        }
    }

    /**
     * Tạo người dùng mới.
     */
    public function create($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|max:2048', // Avatar là ảnh, tối đa 2MB
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Dữ liệu không hợp lệ');
            return false;
        }

        DB::beginTransaction();
        try {
            $userData = $request->except('_token', 'avatar', 'password');
            $userData['password'] = bcrypt($request->password);

            // Xử lý avatar nếu có
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $userData['avatar'] = $this->saveAvatar($file);
            }

            User::create($userData);

            DB::commit();
            Session::flash('success', 'Thêm tài khoản thành công');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error("Error creating user: " . $err->getMessage());
            Session::flash('error', 'Thêm tài khoản lỗi');
            return false;
        }

        return true;
    }

    /**
     * Cập nhật thông tin người dùng, bao gồm avatar.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|max:2048', // Avatar là ảnh, tối đa 2MB
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Dữ liệu không hợp lệ');
            return false;
        }

        $user = User::find($id);
        if (!$user) {
            Session::flash('error', 'Người dùng không tồn tại');
            return false;
        }

        DB::beginTransaction();
        try {
            // Cập nhật thông tin người dùng
            $user->fill($request->only([
                'name', 'email', 'role', 'address', 'phone',
            ]));

            // Xử lý cập nhật avatar nếu có
            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ
                if ($user->avatar) {
                    $this->deleteOldAvatar($user->avatar);
                }

                // Lưu avatar mới
                $file = $request->file('avatar');
                $user->avatar = $this->saveAvatar($file);
            }

            $user->save();

            DB::commit();
            Session::flash('success', 'Cập nhật tài khoản thành công');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error("Error updating user ID $id: " . $err->getMessage());
            Session::flash('error', 'Có lỗi xảy ra, vui lòng thử lại');
            return false;
        }

        return true;
    }

    /**
     * Lấy danh sách người dùng trong thùng rác.
     */
    public function getTrashedUsers()
    {
        return User::onlyTrashed()->paginate(15);
    }

    /**
     * Xóa mềm danh sách người dùng.
     */
    public function deleteUsersList(array $userIds)
    {
        try {
            User::whereIn('id', $userIds)->delete();
            return ['status' => true, 'message' => 'Xóa tài khoản thành công!'];
        } catch (\Exception $e) {
            Log::error("Error deleting users: " . $e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Xóa tài khoản thất bại.'];
        }
    }

    /**
     * Khôi phục danh sách người dùng từ thùng rác.
     */
    public function restoreUsersList(array $userIds)
    {
        try {
            User::withTrashed()->whereIn('id', $userIds)->restore();
            return ['status' => true, 'message' => 'Khôi phục tài khoản thành công!'];
        } catch (\Exception $e) {
            Log::error("Error restoring users: " . $e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Khôi phục tài khoản thất bại.'];
        }
    }

    /**
     * Xóa vĩnh viễn danh sách người dùng khỏi thùng rác.
     */
    public function forceDeleteUsersList(array $userIds)
    {
        try {
            User::withTrashed()->whereIn('id', $userIds)->forceDelete();
            return ['status' => true, 'message' => 'Xóa tài khoản vĩnh viễn thành công!'];
        } catch (\Exception $e) {
            Log::error("Error force deleting users: " . $e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Xóa tài khoản vĩnh viễn thất bại.'];
        }
    }

    /**
     * Khôi phục tất cả người dùng từ thùng rác.
     */
    public function restoreAllUsers()
    {
        try {
            $trashedUsers = User::onlyTrashed()->count();
            if ($trashedUsers == 0) {
                return ['status' => false, 'message' => 'Không có tài khoản nào cần khôi phục.'];
            }

            User::onlyTrashed()->restore();
            return ['status' => true, 'message' => 'Khôi phục tất cả tài khoản thành công!'];
        } catch (\Exception $e) {
            Log::error("Error restoring all users: " . $e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Khôi phục thất bại.'];
        }
    }

    /**
     * Xóa vĩnh viễn một người dùng khỏi thùng rác.
     */
    public function forceDeleteUser($id)
    {
        try {
            $user = User::withTrashed()->find($id);
            if (!$user) {
                return ['status' => false, 'message' => 'Người dùng không tồn tại.'];
            }

            // Xóa avatar nếu tồn tại trước khi xóa vĩnh viễn
            if ($user->avatar) {
                $this->deleteOldAvatar($user->avatar);
            }

            $user->forceDelete();
            return ['status' => true, 'message' => 'Xóa tài khoản vĩnh viễn thành công!'];
        } catch (\Exception $e) {
            Log::error("Error force deleting user ID $id: " . $e->getMessage());
            return ['status' => false, 'message' => 'Có lỗi xảy ra. Xóa thất bại.'];
        }
    }
}
