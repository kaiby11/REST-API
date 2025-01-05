
// Fungsi untuk mengedit tugas
function editTask(id) {
    var title = prompt("Edit Task Title: ");
    var description = prompt("Edit Task Description: ");
    var status = prompt("Edit Task Status: ");

    if (title && description && status) {
        var xhr = new XMLHttpRequest();
        xhr.open("PUT", "todo_api.php", true); // URL API
        xhr.setRequestHeader("Content-Type", "application/json");

        // Kirim data yang diubah ke server
        xhr.onload = function () {
            var response = JSON.parse(xhr.responseText);
            alert(response.message);

            if (xhr.status == 200) {
                // Menampilkan pembaruan tugas di daftar
                var taskElement = document.getElementById("task-" + id);
                taskElement.innerHTML = `
                    <div>
                        <strong>${title}</strong>
                        <p>${description}</p>
                        <small>Status: ${status}</small>
                    </div>
                    <div>
                        <button class="btn btn-warning btn-sm" onclick="editTask(${id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTask(${id})">Delete</button>
                    </div>
                `;
            }
        };

        // Mengirim data untuk mengupdate tugas
        xhr.send(JSON.stringify({ id: id, title: title, description: description, status: status }));
    }
}

// Fungsi untuk menghapus tugas menggunakan AJAX
function deleteTask(id) {
    if (confirm("Are you sure you want to delete this task?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("DELETE", "todo_api.php", true); // URL API
        xhr.setRequestHeader("Content-Type", "application/json");

        // Kirim ID tugas dalam body request
        xhr.onload = function () {
            var response = JSON.parse(xhr.responseText);
            alert(response.message); // Menampilkan pesan sukses/gagal

            if (xhr.status == 200 && response.message !== "Task not found") {
                document.getElementById("task-" + id).remove(); // Menghapus elemen HTML tugas
            }
        };

        xhr.send(JSON.stringify({ "id": id })); // Mengirim ID dalam format JSON
    }
}

