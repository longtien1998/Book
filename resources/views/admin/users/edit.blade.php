@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{ $title }}</h4>
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" action="{{route('users.update', $user->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Tên tài khoản</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="name" placeholder="Nhập tên" class="form-control p-0 border-0" value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Email</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Nhập địa chỉ email" class="form-control p-0 border-0" name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Chức năng</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="role" id="role" class="form-select shadow-none p-0 border-0 form-control-line">
                                            <option value="admin"
                                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="customer"
                                                {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                                Customer
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Địa chỉ</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="address" class="form-control p-0 border-0" placeholder="Nhập địa chỉ" value="{{ old('address', $user->address) }}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Số điện thoại</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" placeholder="Nhập số điện thoại" class="form-control p-0 border-0" name="phone" value="{{ old('phone', $user->phone ) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="col-sm-12 text-end">
                                    <button class="btn btn-success">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <h5>Thông báo !</h5>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

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
