<?php
include 'database_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $id = $conn->real_escape_string($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $task_due = $conn->real_escape_string($_POST['task_due']);
    $priority = $conn->real_escape_string($_POST['priority']);
    $status = $conn->real_escape_string($_POST['status']);

   
    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, task_due=?, priority=?, Status=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $task_due, $priority, $status, $id);

    if ($stmt->execute()) {
       
        header('Location: view_tasks.php?status=updated');
        exit;
    } else {
        // Error handling
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>