@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Thêm quảng cáo</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('home') }}" class="fw-normal">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Container fluid -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" action="{{ route('advertisements.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Tiêu đề quảng cáo</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="title" placeholder="Nhập tiêu đề" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Liên kết (URL)</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="url" name="url" placeholder="https://example.com" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Mô tả</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea name="description" class="form-control p-0 border-0" placeholder="Mô tả ngắn gọn về quảng cáo" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Ngày bắt đầu</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="date" name="start_date" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Ngày kết thúc</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="date" name="end_date" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Trạng thái</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="is_active" class="form-select shadow-none p-0 border-0 form-control-line">
                                            <option value="1">Hoạt động</option>
                                            <option value="0">Không hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Hình ảnh</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="file" name="image_path" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Thêm quảng cáo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <h5>Thông báo!</h5>
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
    <!-- End Container fluid -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center"> 2021 © Ample Admin brought to you by <a href="https://www.wrappixel.com/">wrappixel.com</a>
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
@endsection
