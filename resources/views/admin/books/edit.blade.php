@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Cập nhật sách</h4>
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
                        <form class="form-horizontal form-material" action="{{ route('books.update', $books->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Tên sách</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="title" value="{{ old('title', $books->title) }}" placeholder="Sách" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Tên tác giả</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="author" value="{{ old('author', $books->author) }}" placeholder="Tác giả" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Giá</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" name="price" value="{{ old('price', $books->price) }}" placeholder="0" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Mô tả</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea name="description" class="form-control p-0 border-0" placeholder="Mô tả" rows="4">{{ old('description', $books->description) }}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Tình trạng</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="availability_status" class="form-select shadow-none p-0 border-0 form-control-line">
                                            <option value="1" {{ old('availability_status', $books->availability_status) == 1 ? 'selected' : '' }}>Còn hàng</option>
                                            <option value="2" {{ old('availability_status', $books->availability_status) == 2 ? 'selected' : '' }}>Hết hàng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Danh mục</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="category_id" class="form-select shadow-none p-0 border-0 form-control-line">
                                            @foreach ($categories as $ctgr)
                                            <option value="{{ $ctgr->id }}" {{ old('category_id', $books->category_id) == $ctgr->id ? 'selected' : '' }}>
                                                {{ $ctgr->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Năm xuất bản</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="date" name="publication_year" value="{{ old('publication_year', $books->publication_year) }}" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-6 mb-4">
                                    <label class="col-md-12 p-0">Nhà xuất bản</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="publisher" value="{{ old('publisher', $books->publisher) }}" placeholder="Nhà xuất bản" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Số lượng</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $books->stock_quantity) }}" placeholder="0" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Mã ISBN</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="isbn" value="{{ old('isbn', $books->isbn) }}" placeholder="ISBN" class="form-control p-0 border-0">
                                    </div>
                                </div>
                                <div class="form-group col-xl-4 mb-4">
                                    <label class="col-md-12 p-0">Ngôn ngữ sách</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="language" value="{{ old('language', $books->language) }}" placeholder="Tiếng Việt" class="form-control p-0 border-0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Hình ảnh bìa sách</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="file" name="image_url" class="form-control p-0 border-0">
                                </div>
                                @if ($books->image_url)
                                <img src="{{ asset('upload/books/' . $books->image_url) }}" alt="Bìa sách" class="mt-2" style="width: 150px;">
                                @endif
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
