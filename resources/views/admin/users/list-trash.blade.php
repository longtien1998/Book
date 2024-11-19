@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Danh sách tài khoản sách đã xóa</h4>
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
                        <form method="POST" action="{{route('users.trash.search')}}">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tài khoản...">
                                <button type="submit" class="btn btn-primary btn-sm ms-2 col-lg-2">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="white-box">
                    <a href="{{route('users.add')}}" class="btn btn-success text-white">Thêm tài khoản</a>
                    <a href="{{route('users.trash.list')}}" class="btn btn-info text-white">Tất cả tài khoản đã xóa</a>
                    <div class="form-group row justify-content-between m-0 p-0">
                        <div class="col-sm-6 my-3">
                            <div>Đã chọn <strong id="total-songs">0</strong> tài khoản</div>
                        </div>
                        <div class="col-sm-6 my-3 d-flex justify-content-end align-items-center gap-2">
                            <form action="{{route('users.trash.restore')}}" class="d-inline" method="post" id="form-restore">
                                @csrf
                                <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tài khoản đã chọn?')">Khôi phục tài khoản</button>
                            </form>
                            <a href="{{route('users.trash.restore-all')}}" class="btn btn-success text-white">Khôi phục tất cả tài khoản</a>
                            <form action="{{route('users.trash.delete')}}" class="d-inline" method="post" id="form-delete">
                                @csrf
                                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                                <button type="submit" class="btn btn-danger text-white" onclick="return confirm('Xác nhận xóa tài khoản đã chọn?')">Xóa tài khoản</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap text-center" id="myTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                                    <th class="border-top-0">ID</th>
                                    <th class="border-top-0">Tên tài khoản</th>
                                    <th class="border-top-0">Chức năng</th>
                                    <th class="border-top-0">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users))
                                @php $stt = 1; @endphp
                                @foreach($users as $user)
                                <tr>
                                    <td><input type="checkbox" class="check_list" value="{{$user->id}}"></td>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        <a href="{{route('users.trash.destroy',$user->id)}}"><i class="fas fa-trash-alt"></i></a>
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
                                {{$users->links('pagination::bootstrap-5')}}
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
