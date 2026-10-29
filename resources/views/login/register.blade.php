
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styele.css') }}">
    <title> new login</title>
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
    <form class="login-form" action="{{ route('register.store') }}" method="POST">
@csrf
        <h2>new acount</h2>
        <div class="input-group">
            <label for="name">full name</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your name"
                required
            >
        </div>

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

        </div>

        <button type="submit">Login</button>


    </form>
</div>

</body>
</html>
