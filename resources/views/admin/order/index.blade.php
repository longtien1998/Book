@extends('admin.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Danh sách đơn hàng</h4>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <div class="form-group row justify-content-between m-0 p-0">
                            <div class="col-sm-6 my-3 d-flex justify-content-star align-items-center">
                            </div>
                            <div class="col-sm-6 my-3 d-flex justify-content-end">
                                <form method="POST" action="{{route('order.find')}}">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="text" name="search" class="form-control" placeholder="Nhập cần tìm...">
                                        <input type="submit" class="btn btn-primary btn-sm ht-3" value="Tìm kiếm">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap text-center" id="myTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                                        <th class="border-top-0">ID</th>
                                        <th class="border-top-0">Tên</th>
                                        <th class="border-top-0">Tổng đơn hàng</th>
                                        <th class="border-top-0">Phương thức TT</th>
                                        <th class="border-top-0">Địa chỉ</th>
                                        <th class="border-top-0">Tình trạng</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($orders))
                                        @php    
                                        $stt = 1;
                                        $status = [
                                            '1' => 'đang xử lý',
                                            '2' => 'đã giao',
                                            '3' => 'đã hủy',
                                        ]
                                        @endphp
                                    @foreach($orders as $order)
                                        <tr>
                                            <td><input type="checkbox" class="check_list" value="{{$order->id}}"></td>
                                            <td>{{ $stt++ }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>{{$order->shipping_address}}</td>
                                            <td>
                                                <select class="form-control form-select text-center">
                                                    @foreach ($status as $key => $val)
                                                        <option value="{{ $key }}" {{ $order->status == $val ? 'selected' : '' }}>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <a href="{{route('order.edit', $order->id)}}" class="me-2"><i class="fas fa-edit"></i></a>
                                                <form action="{{route('order.destroy', $order->id)}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link" onclick="return confirm('Xác nhận xóa ?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="10">Không có dữ liệu</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination-area" style="display: flex; justify-content: center; align-items: center;">
                                <ul class="pagination">
                                    {{$orders->links('pagination::bootstrap-4')}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.component.footer')
    </div>
@endsection