@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Thêm mới coupon</h4>
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
                            $url = ($config['method'] == 'create') ? route('coupon.store') : route('coupon.update',$coupon-> id);
                        @endphp
                        <form class="form-horizontal form-material" action="{{ $url }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Tên mã voucher<span class="text-danger">(*)</span></label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" 
                                        name="name" placeholder="Sách..." class="form-control p-0 border-0" value="{{ old('name', ($coupon-> name) ?? '' ) }}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Mã code<span class="text-danger">(*)</span></label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Tác giả...." class="form-control p-0 border-0" 
                                        name="code" value="{{ old('code', ($coupon-> code) ?? '' ) }}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Số lượng mã</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" placeholder="0" class="form-control p-0 border-0" 
                                        name="quantity" value="{{ old('quantity', ($coupon-> quantity) ?? '' ) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  mb-4">
                                <label class="col-md-12 p-0">Mô tả</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="0" class="form-control p-0 border-0"
                                    name="description" value="{{ old('description', ($coupon-> description) ?? '' ) }}">
                                </div>
                            </div>
                            <div class="card-body bg-light border">
                                <div class="row">
                                    @php
                                        $conditionVal = [
                                            '1' => 'Giảm theo %',
                                            '2' => 'Giảm theo tiền',
                                        ]
                                    @endphp
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="col-md-12 p-0">Tính năng mã</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select class="form-select shadow-none p-0 border-0 form-control-line"  
                                            name="condition">
                                                @foreach ($conditionVal as $keyC => $valC)
                                                <option value="{{ $keyC }}" 
                                                {{$keyC == old('condition', (isset($coupon->condition)) ? $coupon->condition : '') ? 'selected' : ''}} >
                                                {{ $valC }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="col-md-12 p-0">Nhập % or tiền giảm<span class="text-danger">(*)</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="number" placeholder="0" 
                                            class="form-control p-0 border-0" 
                                            name="number"
                                            value="{{ old('number', ($coupon-> number) ?? '' ) }}"
                                            >
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    @php
                                        $statusVal = [
                                            '1' => 'Bật',
                                            '2' => 'Tắt',
                                        ]
                                    @endphp
                                    <div class="form-group col-xl-6 mb-4">
                                        <label class="col-md-12 p-0">Tình trạng</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select class="form-select shadow-none p-0 border-0 form-control-line" 
                                            name="status">
                                            @foreach ($statusVal as $keyS => $valS)
                                            <option value="{{ $keyS }}" {{$keyS == old('status', (isset($coupon->status)) ? $coupon->status : '') ? 'selected' : ''}} >{{ $valS }}</option>
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
