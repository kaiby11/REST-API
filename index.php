<?php
include('db.php');

// Mengambil semua tugas dari database
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">To-Do List</h1>

        <!-- Tombol untuk menambahkan tugas -->
        <div class="mb-3 text-end">
            <a href="add_task.php" class="btn btn-success">Add New Task</a>
        </div>

        <!-- Daftar Tugas -->
        <div class="list-group" id="task-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center" id="task-<?php echo $row['id']; ?>">
                        <div>
                            <strong><?= $row['title']; ?></strong>
                            <p><?= $row['description']; ?></p>
                            <small>Status: <?= $row['status']; ?></small>
                        </div>
                        <div>
                            <button class="btn btn-warning btn-sm" onclick="editTask(<?= $row['id']; ?>)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTask(<?= $row['id']; ?>)">Delete</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No tasks found!</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
