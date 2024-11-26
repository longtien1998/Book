@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Thêm mới sách</h4>
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
                        <form class="form-horizontal form-material" action="{{route('books.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Tên sách</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="title" placeholder="Sách" class="form-control p-0 border-0" value="{{old('title')}}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Tên tác giả</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Tác giả" class="form-control p-0 border-0" name="author" value="{{old('author')}}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Giá</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" placeholder="0" class="form-control p-0 border-0" name="price" value="{{old('price')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  mb-4">
                                <label for="example-email" class="col-md-12 p-0">Mô tả</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea name="description" class="form-control p-0 border-0" placeholder="Mô tả" rows="4" id="">{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Tình trạng</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="availability_status" value="{{old('availability_status')}}" class="form-select shadow-none p-0 border-0 form-control-line">
                                            <option value="1">Còn hàng</option>
                                            <option value="2">Hết hàng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Danh mục</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="category_id" class="form-select shadow-none p-0 border-0 form-control-line">
                                            @foreach ($categories as $ctgr)
                                            <option value="{{$ctgr->id}}">{{$ctgr->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Năm xuất bản</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="date" class="form-control p-0 border-0" name="publication_year" value="{{old('publication_year')}}">
                                    </div>
                                </div>

                                <div class="form-group col-xl-6 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Nhà xuất bản</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Nhà xuất bản" class="form-control p-0 border-0" name="publisher" value="{{old('publisher')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Số lượng</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" placeholder="0" class="form-control p-0 border-0" name="stock_quantity" value="{{old('stock_quantity')}}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Mã ISBN</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="ISBN" class="form-control p-0 border-0" name="isbn" value="{{old('isbn')}}">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label for="example-email" class="col-md-12 p-0">Ngôn ngữ sách</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Tiếng Việt" class="form-control p-0 border-0" name="language" value="{{old('language')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="example-email" class="col-md-12 p-0">Hình ảnh bìa sách</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="file" placeholder="Tác giả" class="form-control p-0 border-0" name="image_url" value="{{old('image_url')}}">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Thêm mới</button>
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
