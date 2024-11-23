@extends('admin.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Danh sách phiếu giảm giá</h4>
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
                                <form method="POST" action="{{route('coupon.find')}}">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="text" name="search" class="form-control" placeholder="Nhập tên sách cần tìm...">
                                        <input type="submit" class="btn btn-primary btn-sm ht-3" value="Tìm kiếm">
                                    </div>
                                </form>
                                <div class="ms-2">
                                    <a href="{{ route('coupon.create') }}" class="btn btn-primary text-white me-1">Thêm coupon</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap text-center" id="myTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                                        <th class="border-top-0">ID</th>
                                        <th class="border-top-0">Tên</th>
                                        <th class="border-top-0">Mã code</th>
                                        <th class="border-top-0">Số lượng</th>
                                        <th class="border-top-0">Điều kiện mã giảm giá</th>
                                        <th class="border-top-0">Số giảm</th>
                                        <th class="border-top-0">Tình trạng</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($coupons))
                                    @php $stt = 1; @endphp
                                    @foreach($coupons as $coupon)
                                    <tr>
                                        <td><input type="checkbox" class="check_list" value="{{$coupon->id}}"></td>
                                        <td>{{$stt}}</td>
                                        <td>{{$coupon->name}}</td>
                                        <td>{{$coupon->code}}</td>
                                        <td>{{$coupon->quantity}}</td>
                                        <td>{{$coupon->condition}}</td>
                                        <td>{{$coupon->number}}</td>
                                        <td>
                                            <?php
                                                if ($coupon ->status == 1){
                                                    ?>
                                                    <div class="form-switch">
                                                    <input class="form-check-input status js-switch" type="checkbox" checked>
                                                </div>
                                                    <?php
                                                }else {
                                                    ?>
                                                    <div class="form-switch">
                                                        <input class="form-check-input status js-switch" type="checkbox" >
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="{{route('coupon.edit', $coupon->id)}}" class="me-2"><i class="fas fa-edit"></i></a>
                                            <form action="{{route('coupon.destroy', $coupon->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link" onclick="return confirm('Xác nhận xóa ?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php $stt++; @endphp
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
                                    {{$coupons->links('pagination::bootstrap-4')}}
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