<?php
include 'header.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database_connect.php';

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the username exists in the database
    $stmt = $conn->prepare("SELECT id, username, password, title FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['title'] = $user['title'];

            // Redirect based on role
            if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor') {
                header("Location: view_tasks.php");
            } else {
                header("Location: tasks_viewer.php"); // Redirect non-supervisory roles here
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
    <body class="login-body">
    <img src="images/egg.jpg" alt="Background image" class="background-image2">
        <div class="login-container">
            <h2 class="login-title">Login</h2>

            <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="username" class="form-label">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
            </div>
            <input type="submit" value="Login" class="form-submit">

            <p class="signup-prompt">Don't have an account? <a href="register.php" class="signup-link">Register here</a>.</p>
            </form>
        </div>
    </body>
</html>