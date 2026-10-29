<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styele.css') }}">
    <title>نسيت كلمة المرور</title>
</head>
<body>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

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
    <form class="login-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <h2>طلب إعادة تعيين كلمة المرور</h2>

        <div class="input-group">
            <label for="email">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit">إرسال رابط إعادة التعيين</button>

        <p class="register-link">
            <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
        </p>
    </form>
</div>

</body>
</html>
