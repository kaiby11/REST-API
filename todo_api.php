<?php
header("Content-Type: application/json");
include('db.php');

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            get_task($id);
        } else {
            get_tasks();
        }
        break;

    case 'POST':
        add_task();
        break;

    case 'PUT':
        update_task();
        break;

    case 'DELETE':
        delete_task();
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_tasks() {
    global $conn;
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        echo json_encode($tasks);
    } else {
        echo json_encode(["message" => "No tasks found"]);
    }
}

function get_task($id) {
    global $conn;
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
        echo json_encode($task);
    } else {
        echo json_encode(["message" => "Task not found"]);
    }
}

function add_task() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);

    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    $sql = "INSERT INTO tasks (title, description, status) VALUES ('$title', '$description', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "New task created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

function update_task() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];
    $title = mysqli_real_escape_string($conn, $data['title']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    $status = mysqli_real_escape_string($conn, $data['status']);

    $sql = "UPDATE tasks SET title = '$title', description = '$description', status = '$status' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Task updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

function delete_task() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $sql = "DELETE FROM tasks WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Task deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting task: " . $conn->error]);
    }
}
?>
