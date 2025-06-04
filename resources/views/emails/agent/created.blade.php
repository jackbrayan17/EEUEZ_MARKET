<!DOCTYPE html>
<html>
<head>
    <title>Your Storekeeper Account Credentials</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}</h1>
    <p>You have been registered as a storekeeper. Here are your account details:</p>

    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>Please log in using these credentials and change your password after logging in.</p>

    <p>Thank you!</p>
</body>
</html>
