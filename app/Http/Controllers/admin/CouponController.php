<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller{

    public function index(){
        $coupons = Coupon::paginate(15);
        return view('admin.coupon.index', compact('coupons',));
    }

    public function create(){
        $config['method'] = 'create';
        return view('admin.coupon.store', compact('config',));
    }

    public function store(CouponRequest $request) {
        try {
            $payload = $request->only($this->payload());
            $coupon = new Coupon();
            $coupon->fill($payload); 
            $coupon->save();
            return redirect()->route('coupon.index')->with('success', 'Thêm mã giảm giá thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi' . $e->getMessage());
            return redirect()->route('coupon.index')->with('error', 'Thêm mã giảm giá thất bại');
        }
    }

    public function edit($id){
        $config['method'] = 'edit';
        try {
            $coupon = Coupon::findOrFail($id); 
            return view('admin.coupon.store', compact('config','coupon',)); 
        } catch (\Exception $e) {
            Log::error('Lỗi' . $e->getMessage());
            return redirect()->route('coupon.index')->with('error', 'Không tìm thấy mã giảm giá.');
        }
    }

    public function update(CouponRequest $request, $id) {
        try {
            $payload = $request->only($this->payload());
            $coupon = Coupon::findOrFail($id);
            $coupon->fill($payload);
            $coupon->save();
            return redirect()->route('coupon.index')->with('success', 'Cập nhật mã giảm giá thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật mã giảm giá: ' . $e->getMessage());
            return redirect()->route('coupon.index')->with('error', 'Cập nhật mã giảm giá thất bại');
        }
    }

    public function destroy($id){
        try {
            Coupon::find($id)->delete();
            return redirect()->route('coupon.index')->with('success', 'Xoá bản ghi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bản ghi thất bại.');
        }
    }

    public function find(Request $request){
        try {
            $query = $request->search;
            $coupons = Coupon::where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('code', 'LIKE', '%' . $query . '%')
                        ->paginate(10); 
            if ($coupons->isEmpty()) {
                return redirect()->route('users.list')->with('error', 'Không tìm thấy tài khoản nào phù hợp với từ khóa');
            } else {
                return view('admin.coupon.index', compact('coupons'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm thấy tài khoản nào phù hợp với từ khóa.');
        }
    }

    private function payload() {
        return [
            'name',
            'code',
            'quantity',
            'description',
            'condition',
            'number',
            'status',
        ];
    }
   
}
