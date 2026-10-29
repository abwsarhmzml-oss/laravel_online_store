<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styele.css') }}">
    <title>إعادة تعيين كلمة المرور</title>
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
    <form class="login-form" method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <h2>إعادة تعيين كلمة المرور</h2>

        <div class="input-group">
            <label for="email">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Enter your email" required autofocus>
        </div>

        <div class="input-group">
            <label for="password">كلمة المرور الجديدة</label>
            <input id="password" type="password" name="password" placeholder="New password" required>
        </div>

        <div class="input-group">
            <label for="password_confirmation">تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password" required>
        </div>

        <button type="submit">إعادة التعيين</button>

        <p class="register-link">
            <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
        </p>
    </form>
</div>

</body>
</html>
