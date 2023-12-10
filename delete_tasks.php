<?php
session_start();

// Check user role before allowing deletion
if (!isset($_SESSION['logged_in']) || ($_SESSION['title'] != 'Manager' && $_SESSION['title'] != 'Supervisor')) {
    // Redirect them to the login page or error page
    header('Location: login.php'); // This should redirect to your login page or a permission error page
    exit();
}

include 'database_connect.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect back to view_tasks.php with a success message
        header('Location: view_tasks.php?status=deleted');
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Task ID not specified.";
}

$conn->close();
?>