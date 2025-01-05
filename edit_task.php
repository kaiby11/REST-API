<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil tugas berdasarkan ID
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);
    $task = $result->fetch_assoc();
}

// Proses untuk memperbarui tugas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET title = '$title', description = '$description', status = '$status' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Task</h1>

        <!-- Formulir untuk mengedit tugas -->
        <form action="edit_task.php?id=<?php echo $task['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $task['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo $task['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="Pending" <?php if ($task['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                    <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
