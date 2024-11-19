@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Profile page</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{route('home')}}" class="fw-normal">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-12">
                    <div class="white-box">
                        <div class="user-bg"> <img width="100%" alt="user" src="plugins/images/large/img1.jpg">
                            <div class="overlay-box">
                                <div class="user-content">
                                    <a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg"
                                            class="thumb-lg img-circle" alt="img"></a>
                                    <h4 class="text-white mt-2">{{$user->name}}</h4>
                                    <h5 class="text-white mt-2">{{$user->email}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="user-btm-box mt-5 d-md-flex">
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1>258</h1>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1>125</h1>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1>556</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal form-material" action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Tên</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="form-control p-0 border-0">
                                        @error('name')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Email</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" value="{{ old('email', $user->email) }}"
                                            class="form-control p-0 border-0" name="email"
                                            id="example-email">
                                        @error('email')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Mật khẩu</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="password" name="password" value="" class="form-control p-0 border-0">
                                        @error('password')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Nhập lại mật khẩu</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="password" name="password_confirmation" value="" class="form-control p-0 border-0">
                                        @error('password_confirmation')
                                            <div class="text-danger pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Số điện thoại</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0123456789"
                                            class="form-control p-0 border-0">
                                            @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                             @enderror

                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Địa chỉ</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Địa chỉ của bạn"
                                            class="form-control p-0 border-0">
                                    </div>
                                </div>
                                {{-- <div class="form-group mb-4">
                                    <label class="col-sm-12">Chức năng</label>

                                    <div class="col-sm-12 border-bottom">
                                        <select class="form-select shadow-none p-0 border-0 form-control-line">
                                            <option>Quản trị viên</option>
                                            <option>Người dùng</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group mb-4">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center"> 2021 © Ample Admin brought to you by <a
            href="https://www.wrappixel.com/">wrappixel.com</a>
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
@endsection
