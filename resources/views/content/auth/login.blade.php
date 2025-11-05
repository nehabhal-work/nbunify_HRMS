<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELS Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #260045, #4B0049);
            margin: 0;
            overflow: hidden;
        }

        .main-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .left-side {
            flex: 1;
            background: linear-gradient(160deg, #4B0049, #260045);
            border-top-right-radius: 250px;
            border-bottom-right-radius: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 40px;
            text-align: center;
        }

        /* .left-side img {
            width: 90px;
            margin-bottom: 25px;
        }

        .left-side h2 {
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .left-side h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .left-side p {
            font-size: 0.9rem;
            max-width: 280px;
            line-height: 1.5;
            opacity: 0.9;
        } */

        .right-side {
            flex: 1;
            background: #fff;
            border-top-left-radius: 250px;
            border-bottom-left-radius: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 80px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .right-side h3 {
            font-weight: 600;
            color: #222;
            margin-bottom: 30px;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
            margin-bottom: 25px;
            font-size: 0.95rem;
            padding-left: 0;
        }

        .form-control:focus {
            border-color: #4B0049;
            box-shadow: none;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .form-check-label a {
            color: #4B0049;
            text-decoration: none;
        }

        .btn {
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 500;
        }

        .btn-els {
            background-color: #4B0049;
            border: none;
        }

        .btn-outline-els {
            border-color: #4B0049;
            color: #4B0049;
        }

        .btn-outline-els:hover {
            background-color: #4B0049;
            color: #fff;
        }

        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }

            .left-side,
            .right-side {
                border-radius: 0;
                padding: 50px 30px;
            }

            .left-side img {
                width: 70px;
            }
        }
    </style>
</head>

<body>

    <div class="main-container">
        <!-- Left Panel -->
        <div class="left-side">
            <img src="{{ asset('assets/img/branding/image.png') }}" alt="SRK Logo" width="500" height="200" />
        </div>

        <!-- Right Panel -->
        <div class="right-side">
            {{-- <h3>Login to Your Account!</h3> --}}
            <h3>Welcome To EasyLife Solutions!</h3>
            <form id="loginForm" class="mb-3" action="{{ route('login') }}" method="post">
                @csrf
                @method('post')
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"
                        required>
                    <button type="button"
                        class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent"
                        id="togglePassword">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger text-center mx-auto w-75 mt-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-outline-els">Log-in</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const toggleIcon = document.querySelector("#toggleIcon");

        togglePassword.addEventListener("click", () => {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            toggleIcon.classList.toggle("bi-eye");
            toggleIcon.classList.toggle("bi-eye-slash");
        });
    </script>

</body>

</html>
