<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style>
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card-bg {
            background-color: rgba(255, 255, 255, 0.9); /* Latar belakang semi-transparan */
            max-width: 450px;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .form-control-bg {
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }
        .btn-bg {
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        h2 {
            font-weight: 700;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card-bg">
            <h2 class="text-center mb-4">Aplikasi Penjualan</h2>
            <p class="text-center text-muted mb-4">Silakan masuk untuk melanjutkan</p>

            <form method="POST" action="{{ route('login.proses_login') }}">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control form-control-bg" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-control-bg" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-bg">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>