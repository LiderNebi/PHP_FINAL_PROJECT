<?php
 include "header.php";
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database_connect.php';

    // Retrieve and sanitize form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // This will be hashed before storage
    $title = $conn->real_escape_string($_POST['title']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, title) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $title);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}

// If the form hasn't been submitted or after handling the submission, display the form
?>
<?php include 'footer.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Add any additional CSS or JS here -->
</head>
<body class="login-body">
<img src="images/tomato.jpg" alt="Background image" class="background-image3">
    <div class="login-container">
        <h2 class="login-title">User Registration</h2>

    <form action="register.php" method="post" enctype="multipart/form-data" class="login-form">
        <div class="form-group">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
        </div>
        <div class="form-group">
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        </div>
 
        <div class="form-group">
        <label for="title">Title:</label><br>
        <select id="title" name="title">
            <option value="Manager">Manager</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Cook">Cook</option>
            <option value="Garnisher">Garnisher</option>
            <option value="Barista">Barista</option>
        </select><br>
        </div>

        <input type="submit" value="Register">
    </form>
</body>
</html>