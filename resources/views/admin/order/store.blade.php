@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Chỉnh sửa</h4>
            </div>
        </div>
    </div>
    @include('admin.component.error')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $url = ($config['method'] == 'create') ? route('order.store') : route('order.update',$order-> id);
                        @endphp
                        <form class="form-horizontal form-material" action="{{ $url }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="form-group col-xl-6 mb-6">
                                    <label class="col-md-12 p-0">Tên<span class="text-danger">(*)</span></label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" 
                                        name="name" placeholder="Tên..." class="form-control p-0 border-0 bg-light" value="{{ old('name', ($order-> user->name) ?? '' ) }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-6">
                                    <label class="col-md-12 p-0">Địa chỉ</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="0" class="form-control p-0 border-0" 
                                        name="shipping_address" value="{{ old('shipping_address', ($order-> shipping_address) ?? '' ) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-light border border-danger">
                                <div class="row">
                                    @php
                                         $status = [
                                            '1' => 'đang xử lý',
                                            '2' => 'đã giao',
                                            '3' => 'đã hủy',
                                        ]
                                    @endphp
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="col-md-12 p-0">Tình trạng</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select class="form-select shadow-none p-0 border-0 form-control-line"  
                                            name="status">
                                                @foreach ($status as $key => $val)
                                                <option value="{{ $val }}" 
                                                {{$val == old('status', (isset($order->status)) ? $order->status : '') ? 'selected' : ''}} >
                                                {{ $val }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="col-md-12 p-0">Tổng giá trị đơn hàng <span class="text-danger">(VND)</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="number" placeholder="0" 
                                            class="form-control p-0 border-0" 
                                            name="total_amount"
                                            value="{{ old('total_amount', convert_price($order-> total_amount, false)) ?? '' }}"
                                            >
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    @php
                                        $methodVal = [
                                            '1' => 'credit_card',
                                            '2' => 'paypal',
                                            '3' => 'cash_on_delivery',
                                        ]
                                    @endphp
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="col-md-12 p-0">Phương thức thanh toán</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select class="form-select shadow-none p-0 border-0 form-control-line" 
                                            name="payment_method">
                                            @foreach ($methodVal as $keyS => $valS)
                                            <option value="{{ $valS }}" {{$keyS == old('payment_method', (isset($order->payment_method)) ? $order->payment_method : '') ? 'selected' : ''}} >{{ $valS }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4 mt-2">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Lưu bản ghi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @include('admin.component.footer')
</div>
@endsection
