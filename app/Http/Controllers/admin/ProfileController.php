<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $validatedData = $request->validated();

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->filled('phone')) {
            $user->phone = $validatedData['phone'];
        }
        if ($request->filled('address')) {
            $user->address = $validatedData['address'];
        }

        // Xử lý cập nhật avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu tồn tại
            if ($user->avatar && Storage::exists('upload/users/' . $user->avatar)) {
                Storage::delete('upload/users/' . $user->avatar);
            }

            // Lưu avatar mới
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/users'), $filename);

            $user->avatar = $filename;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Thông tin đã được cập nhật!');
    }
}
