<?php
include 'header.php';
session_start();
include 'database_connect.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

// ... existing status message code ...

$query = "SELECT * FROM tasks ORDER BY task_due ASC";
$result = $conn->query($query);

$tasks = [];

if ($result->num_rows > 0) {
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tasks</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Make sure this path is correct -->
</head>
<body>
    <h1>Task List</h1>

    

    <?php if (!empty($tasks)): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Image</th>
                <?php if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($tasks as $task): ?>
                <tr class="task-row">
                    <td class="task-title"><?php echo htmlspecialchars($task['title']); ?></td>
                    <td class="task-name"><?php echo htmlspecialchars($task['Name']); ?></td>
                    <td class="task-description"><?php echo htmlspecialchars($task['description']); ?></td>
                    <td class="task-due"><?php echo htmlspecialchars($task['task_due']); ?></td>
                    <td class="task-priority"><?php echo htmlspecialchars($task['priority']); ?></td>
                    <td class="task-status"><?php echo htmlspecialchars($task['Status']); ?></td>
                    <td class="task-image">
                            <?php if (!empty($task['image'])): ?>
                                <img src="/PHP_FINAL_PROJECT/uploads/<?php echo htmlspecialchars($task['image']); ?>" alt="Task Image" class="task-image-preview">
                            <?php else: ?>
                                <span>No image</span>
                            <?php endif; ?>
                    </td>
    <!-- Only show edit/delete for view_tasks.php -->
                    <?php if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor'): ?>
                            <td class="task-actions">
            <a href="edit_tasks.php?id=<?php echo $task['id']; ?>" class="task-edit">Edit</a>
            <a href="delete_tasks.php?id=<?php echo $task['id']; ?>" class="task-delete" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
            <?php if ($_SESSION['title'] == 'Manager' || $_SESSION['title'] == 'Supervisor'): ?>
                <a href="add_tasks.php" class="add-tasks">Add Task</a>
            <?php endif; ?>
        </td>
    <?php endif; ?>
</tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tasks to display.</p>
    <?php endif; ?>
</body>
<?php include 'footer.php'?>
</html>