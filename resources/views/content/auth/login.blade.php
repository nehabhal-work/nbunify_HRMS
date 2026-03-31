<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NB Unify Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f2f5f9;
        }

        /* CONTAINER */
        .container {
            width: 950px;
            height: 520px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        /* LEFT PANEL */
        .left {
            width: 80%;
            background: linear-gradient(135deg, #4facfe, #00c6ff);
            color: #fff;
            padding: 50px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            z-index: 1;
        }

        /* CURVE (CONTROLLED) */
        .left::after {
            content: "";
            position: absolute;
            right: -80px;
            /* reduced so it doesn't hide form */
            top: 0;
            width: 200px;
            height: 100%;
            background: #fff;
            border-radius: 100px 0 0 100px;
            z-index: -1;
        }

        /* LOGO */
        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        /* TEXT */
        .left h4 {
            letter-spacing: 1px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .left h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .left p {
            font-size: 12px;
            opacity: 0.9;
            max-width: 260px;
        }

        /* RIGHT PANEL */
        .right {
            width: 55%;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 2;
            /* ensures it's always on top */
            background: #fff;
        }

        .right h2 {
            margin-bottom: 25px;
            color: #333;
        }

        /* INPUTS */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 12px;
            color: #666;
        }

        .form-group input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ccc;
            padding: 8px 0;
            outline: none;
        }

        .form-group input:focus {
            border-bottom: 1px solid #4facfe;
        }

        /* CHECKBOX */
        .checkbox {
            font-size: 12px;
            margin-top: 10px;
        }

        /* BUTTONS */
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-primary {
            background: #4facfe;
            border: none;
            color: #fff;
        }

        .btn-outline {
            border: 1px solid #4facfe;
            background: transparent;
            color: #4facfe;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- LEFT -->
        <div class="left">
            <div class="logo">🚀</div>
            <h4>WELCOME TO</h4>
            <h2>NB UNIFY</h2>
            <p>
                Where people and payroll move in harmony—
                simple, steady, and built to last.
            </p>
        </div>

        <!-- RIGHT -->
        <div class="right">
            <h2>Login to your account</h2>
            <form action="{{ route('login') }}" method="post">
                @csrf
                @method('post')
                <div class="form-group">
                    <label>E-MAIL ADDRESS</label>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>

                <div class="form-group" style="position:relative;">
                    <label>PASSWORD</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" style="padding-right:35px;">

                    <i class="fa-solid fa-eye" id="toggleIcon" onclick="togglePassword()"
                        style="position:absolute; right:0; top:32px; cursor:pointer; color:#666;">
                    </i>
                </div>

               @if ($errors->any())
                    <div class="alert alert-danger text-center mx-auto w-75 mt-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="buttons">
                    <button class="btn btn-primary">Login</button>
                </div>
            </form>

        </div>

    </div>
    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>