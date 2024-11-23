@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Cập nhật quảng cáo</h4>
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
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" action="{{ route('advertisements.update', $advertisements->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Tiêu đề quảng cáo</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="title" value="{{ old('title', $advertisements->title) }}" placeholder="Nhập tiêu đề" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Liên kết</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="url" name="url" value="{{ old('url',$advertisements->url) }}" placeholder="URL liên kết" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Mô tả</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea name="description" class="form-control p-0 border-0" placeholder="Mô tả quảng cáo" rows="4">{{ old('description', $advertisements->description) }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Ngày bắt đầu</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="date" name="start_date" value="{{old('start_date',$advertisements->start_date->format('Y-m-d'))}}" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Ngày kết thúc</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="date" name="end_date" value="{{old('end_date',$advertisements->end_date ? $advertisements->end_date->format('Y-m-d') : '')}}" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Hình ảnh</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="file" name="image_path" value="{{old('image_path',$advertisements->image_path)}}" class="form-control p-0 border-0" accept="image/*">
                                </div>
                                <img src="{{ asset('upload/ads/' . $advertisements->image_path) }}" alt="Hình ảnh quảng cáo" class="mt-2" style="width: 150px;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Trạng thái</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select name="is_active" class="form-select shadow-none p-0 border-0 form-control-line">
                                        <option value="1" {{ old('is_active', $advertisements->is_active) == 1 ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ old('is_active', $advertisements->is_active) == 0 ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Cập nhật</button>
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
    <footer class="footer text-center">2021 © Ample Admin brought to you by <a href="https://www.wrappixel.com/">wrappixel.com</a></footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
@endsection
