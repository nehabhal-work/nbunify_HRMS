<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NB Unify — Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F0EDE8;
            font-family: 'Public Sans', sans-serif;
        }

        /* ── CARD ── */
        .container {
            width: 960px;
            height: 540px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(74, 124, 142, 0.14);
        }

        /* ── LEFT PANEL ── */
        .left {
            width: 42%;
            background-color: #4A7C8E;
            color: #fff;
            padding: 52px 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* decorative circles */
        .left::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.10);
            top: -80px;
            left: -80px;
        }

        .left::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.10);
            bottom: -50px;
            right: -60px;
        }

        .left-top .brand {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            opacity: 0.75;
            margin-bottom: 6px;
        }

        .left-top .product-name {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .left-top .product-name span {
            display: block;
            font-size: 13px;
            font-weight: 400;
            opacity: 0.7;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .left-middle {
            text-align: center;
            z-index: 1;
        }

        .logo-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
        }

        .left-middle p {
            font-size: 13px;
            line-height: 1.8;
            opacity: 0.80;
            max-width: 240px;
            margin: 0 auto;
        }

        .left-bottom {
            font-size: 11px;
            opacity: 0.5;
            z-index: 1;
        }

        /* ── RIGHT PANEL ── */
        .right {
            width: 58%;
            background-color: #FDFBF8;
            padding: 52px 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-header {
            margin-bottom: 32px;
        }

        .right-header h2 {
            font-size: 22px;
            font-weight: 600;
            color: #2C4A54;
            margin-bottom: 6px;
        }

        .right-header p {
            font-size: 13px;
            color: #7A9AA5;
        }

        /* ── FORM ── */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #7A9AA5;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .form-group input {
            width: 100%;
            border: none;
            border-bottom: 1.5px solid #C8C2BA;
            background: transparent;
            padding: 10px 36px 10px 0;
            font-size: 14px;
            color: #2C4A54;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input::placeholder {
            color: #B0B8BC;
            font-size: 13px;
        }

        .form-group input:focus {
            border-bottom-color: #4A7C8E;
        }

        .toggle-icon {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #A0B4BA;
            font-size: 14px;
        }

        .toggle-icon:hover {
            color: #4A7C8E;
        }

        /* ── ERROR ── */
        .alert-danger {
            background-color: #fdf0f0;
            border: 1px solid #f5c6c6;
            color: #8B2E2E;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            margin-bottom: 16px;
        }

        /* ── BUTTON ── */
        .btn-login {
            margin-top: 8px;
            padding: 12px 36px;
            background-color: #4A7C8E;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background-color: #3D6A7A;
        }

        .btn-login:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- LEFT -->
        <div class="left">
            <div class="left-top">
                <div class="product-name">
                    <span>Welcome to</span>
                    NBUnify HRMS
                </div>
            </div>

            <div class="left-middle">
                <div class="logo-circle">🚀</div>
                <p>
                    Where people and payroll move in harmony —
                    simple, steady, and built to last.
                </p>
            </div>

            <div class="left-bottom">
                © {{ date('Y') }} In-House IT Department
            </div>
        </div>

        <!-- RIGHT -->
        <div class="right">
            <div class="right-header">
                <h2>Sign in to your account</h2>
                <p>Enter your credentials to continue</p>
            </div>

            <form action="{{ route('login') }}" method="post">
                @csrf
                @method('post')

                <div class="form-group">
                    <label>E-Mail Address</label>
                    <div class="input-wrap">
                        <input type="email" name="email" placeholder="Enter your email"
                            value="{{ old('email') }}" autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="password"
                            placeholder="Enter your password" autocomplete="current-password">
                        <i class="fa-solid fa-eye toggle-icon" id="toggleIcon"
                            onclick="togglePassword()"></i>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");
            if (password.type === "password") {
                password.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>

</body>
</html>