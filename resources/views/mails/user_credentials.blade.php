<!DOCTYPE html>
<html>
<head>
    <title>Your Login Credentials</title>
</head>
<body>
    <h1>Welcome to {{ config('app.name') }}</h1>
    <p>Dear {{ $user->name }},</p>
    <p>Here are your login credentials:</p>
    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please use these credentials to log in to your account.</p>
    <p>Thank you,</p>
    <p>{{ config('app.name') }} Team</p>
</body>
</html>
