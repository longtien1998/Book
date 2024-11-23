<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class OrderController extends Controller{

    public function index(){
        $orders = Order::paginate(15);
        return view('admin.order.index', compact('orders',));
    }

    public function store(Request $request) {
        try {
            $payload = $request->only($this->payload());
            $order = new Order();
            $order->fill($payload); 
            $order->save();
            return redirect()->route('order.index')->with('success', 'Thêm bản ghi thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi' . $e->getMessage());
            return redirect()->route('order.index')->with('error', 'Thêm bản ghi thất bại');
        }
    }

    public function edit($id){
        $config['method'] = 'edit';
        try {
            $order = Order::findOrFail($id); 
            return view('admin.order.store', compact('config','order',)); 
        } catch (\Exception $e) {
            Log::error('Lỗi' . $e->getMessage());
            return redirect()->route('order.index')->with('error', 'Không tìm thấy bản ghi.');
        }
    }

    public function update(Request $request, $id){
        try {
            $payload = $request->only($this->payload());
            $valStatus = ['đang xử lý', 'đã giao', 'đã hủy'];
            $valMethod = ['credit_card', 'paypal', 'cash_on_delivery'];

            if (isset($payload['status']) && !in_array($payload['status'], $valStatus)) {
                return redirect()->route('order.index')->with('error', 'Trạng thái không hợp lệ');
            }

            if (isset($payload['payment_method']) && !in_array($payload['payment_method'], $valMethod)) {
                return redirect()->route('order.index')->with('error', 'Phương thức thanh toán không hợp lệ');
            }

            $order = Order::findOrFail($id);
            $order->fill($payload);
            $order->save();

            return redirect()->route('order.index')->with('success', 'Cập nhật bản ghi thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật bản ghi: ' . $e->getMessage());
            return redirect()->route('order.index')->with('error', 'Cập nhật bản ghi thất bại');
        }
    }



    public function destroy($id){
        try {
            Order::find($id)->delete();
            return redirect()->route('order.index')->with('success', 'Xoá bản ghi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Xóa bản ghi thất bại.');
        }
    }

    public function find(Request $request){
        try {
            $query = $request->input('search'); 
            $orders = Order::where('shipping_address', 'LIKE', '%' . $query . '%')
                ->orWhereHas('user', function ($get) use ($query) {
                    $get->where('name', 'LIKE', '%' . $query . '%');
                })
                ->paginate(10); 
                if ($orders->isEmpty()) {
                    return redirect()->route('order.index')->with('error', 'Không tìm từ khóa.');
                } 
                return view('admin.order.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Không tìm từ khóa.');
        }
    }

    private function payload() {
        return [
            'used_id',
            'order_date',
            'total_amount',
            'status',
            'payment_method',
            'shipping_address',
        ];
    }
   
}
