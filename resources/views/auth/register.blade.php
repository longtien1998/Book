<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/fvc.png') }}">
    <title>Đăng ký</title>
    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/app.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-3 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="/" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="/plugins/images/logob.png" alt="" height="40" >
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Bạn chưa có tài khoản? Tạo tài khoản của bạn, chỉ mất chưa đầy một phút</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Họ tên</label>
                                    <input class="form-control" type="text" id="fullname" name="name"
                                        value="{{ old('name') }}"  placeholder="Nhập họ tên">
                                    @error('name')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control" type="text" id="emailaddress" name="email"
                                        value="{{ old('email') }}"  placeholder="Nhập địa chỉ email">
                                    @error('email')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                             placeholder="Nhập mật khẩu">
                                        <div class="input-group-text" data-password="false">
                                            <i class="fa-regular fa-eye"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control"  placeholder="Nhập lại mật khẩu">
                                    @error('password_confirmation')
                                        <div class="text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-success" type="submit">Đăng ký</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Bạn đã có tài khoản? <a href="{{ route('login') }}"
                                    class="text-white ms-1"><b>Đăng nhập</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

</body>
