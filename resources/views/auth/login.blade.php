<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page bg-body-secondary">

<div class="login-box">
    <div class="login-logo mb-3">
        <b>FlexBiz</b> Admin
    </div>

    <div class="card shadow-sm">
        <div class="card-body login-card-body">

            <form method="POST" action="{{ route('login.perform') }}">
                @csrf

                <div class="mb-3">
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>

                <div class="mb-3">
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Mật khẩu"
                           required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Đăng nhập
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
