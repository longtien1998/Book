@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Danh sách bình luận</h4>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <form method="POST" action="{{route('comments.search')}}">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bình luận..." value="{{old('search')}}">
                                <button type="submit" class="btn btn-primary btn-sm ms-2 col-lg-2">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="white-box">
                    <a href="{{route('comments.list')}}" class="btn btn-info text-white">Tất cả bình luận</a>

                    <div class="form-group row justify-content-between m-0 p-0">
                        <div class="col-sm-6 my-3">
                            <div>Đã chọn <strong id="total-songs">0</strong> bình luận</div>
                        </div>
                        <div class="col-sm-6 my-3 d-flex justify-content-end align-items-center">
                            <a href="{{route('comments.trash.list')}}" class="btn btn-success text-white me-2">Danh sách bình luận đã xóa</a>
                            <form action="{{route('comments.delete-list')}}" class="d-inline" method="post" id="form-delete">
                                @csrf
                                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                                <button type="submit" class="btn btn-danger text-white" onclick="return confirm('Xác nhận xóa bình luận đã chọn?')">Xóa bình luận</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap text-center" id="myTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                                    <th class="border-top-0">ID</th>
                                    <th class="border-top-0">Người dùng</th>
                                    <th class="border-top-0">Tên sách</th>
                                    <th class="border-top-0">Nội dung</th>
                                    <th class="border-top-0">Ngày bình luận</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($comments))
                                @php $stt = 1; @endphp
                                @foreach($comments as $comment)
                                <tr>
                                    <td><input type="checkbox" class="check_list" value="{{$comment->id}}"></td>
                                    <td>{{$comment->id}}</td>
                                    <td>{{$comment->user->name}}</td>
                                    <td>{{$comment->book->title}}</td>
                                    <td style="
                                        max-width: 300px;
                                        overflow-wrap: break-word;
                                        white-space: normal;">
                                        {{$comment->content}}
                                    </td>
                                    <td>{{$comment->created_at}}</td>
                                    <td>
                                        <form action="{{route('comments.delete', $comment->id)}}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link " onclick="return confirm('Xác nhận xóa bình luận?')">
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
                                {{$comments->links('pagination::bootstrap-5')}}
                            </ul>
                        </div>
                    </div>
                </div>
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
@section('js')
<script>
    document.querySelector('#check_all_list').addEventListener('click', function() {
        var checkboxes = document.getElementsByClassName('check_list');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }

        getCheckedValues()

    });
    // Gán sự kiện 'submit' cho form
    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_list'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_list');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
</script>

@endsection
