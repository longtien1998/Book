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
                                    <!-- Logo -->
                                    <div class="auth-brand">
                                        <a href="/" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="/plugins/images/logob.png" alt="" height="40">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Đặt lại mật khẩu mới của bạn</p>
                                </div>

                                <form method="POST" action="{{ route('password.store') }}">
                                    @csrf
                                    <!-- Password Reset Token -->
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <!-- Email Address -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)"  autofocus autocomplete="username" placeholder="Nhập email" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mật khẩu mới</label>
                                        <div class="input-group input-group-merge">
                                            <x-text-input id="password" class="form-control" type="password" name="password"  autocomplete="new-password" placeholder="Nhập mật khẩu mới" />
                                        </div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                                        <div class="input-group input-group-merge">
                                            <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation"  autocomplete="new-password" placeholder="Nhập lại mật khẩu" />
                                        </div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <div class="text-center d-grid mt-4">
                                        <x-primary-button class="btn btn-primary">
                                            {{ __('Đặt lại mật khẩu') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Authentication JS -->
        <script src="assets/js/pages/authentication.init.js"></script>
    </body>


</html>
