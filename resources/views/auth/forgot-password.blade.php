<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/fvc.png') }}">
    <title>Đăng nhập</title>
    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/app.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="{{ url('/') }}" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="/plugins/images/logob.png" alt="" height="40">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">
                                    Nhập địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn email có hướng dẫn đặt lại mật khẩu.
                                </p>
                                <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
                            </div>


                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Địa chỉ email của bạn" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit">Đặt lại mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Quay lại <a href="{{ route('login') }}" class="text-white ms-1"><b>Đăng nhập</b></a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
