
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=" {{ asset('css/styele.css') }}">
    <title>login</title>
</head>
<body>

@if ($errors->any())

    <div class="alert alert-danger">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif
<div class="login-container">
    <form class="login-form" action="{{ route('login.submit') }}" method="POST">
@csrf
        <h2>Welcome Back!</h2>
        <p class="subtitle">Please login to your account</p>

        <div class="input-group">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <div class="form-options">
            <label class="remember">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit">Login</button>

        <p class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>

    </form>
</div>

</body>
</html>
