
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h2>Welcome to the Dashboard</h2>
    <button id="logoutButton">Logout</button>

    <p id="message"></p>

    <script>
        const logoutButton = document.getElementById('logoutButton');
        const message = document.getElementById('message');

        logoutButton.addEventListener('click', function() {
            const token = localStorage.getItem('auth_token');
            axios.post('/api/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(function(response) {
                message.textContent = 'Logout successful!';
                localStorage.removeItem('auth_token');
                window.location.href = '/login'; 
                        })
            .catch(function(error) {
                message.textContent = 'An error occurred!';
            });
        });
    </script>
</body>
</html>
