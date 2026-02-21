<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController
{
    public function index()
    {
        $userId = $_SESSION['user_id'];

        $tasks = Task::allByUser($userId);

        echo "<h2>Your Tasks</h2>";
        echo '<a href="?route=task.create">Add Task</a><br><br>';

        foreach ($tasks as $task) {

            $status = $task['is_completed'] ? "✅ Completed" : "❌ Not Completed";

            echo "<div style='margin-bottom:15px; border:1px solid #ccc; padding:10px;'>";
            echo "<strong>{$task['title']}</strong><br>";
            echo "{$task['description']}<br>";
            echo "Status: $status <br>";

            if (!$task['is_completed']) {
                echo "<a href='?route=task.complete&id={$task['id']}'>Mark Completed</a> | ";
            }

            echo "<a href='?route=task.delete&id={$task['id']}'>Delete</a>";
            echo "</div>";
        }

        echo '<br><a href="?route=dashboard">Back to Dashboard</a>';
    }

    public function createForm()
    {
        echo '
        <h2>Create Task</h2>
        <form method="POST" action="?route=task.store">
            <input type="text" name="title" placeholder="Title" required><br><br>
            <textarea name="description" placeholder="Description"></textarea><br><br>
            <button type="submit">Create</button>
        </form>
        ';
    }

    public function store()
    {
        $userId = $_SESSION['user_id'];

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!$title) {
            echo "Title is required.";
            return;
        }

        Task::create($userId, $title, $description);

        header("Location: ?route=tasks");
        exit;
    }

    public function complete()
    {
        $userId = $_SESSION['user_id'];
        $taskId = (int)($_GET['id'] ?? 0);

        Task::markCompleted($taskId, $userId);

        header("Location: ?route=tasks");
        exit;
    }

    public function delete()
    {
        $userId = $_SESSION['user_id'];
        $taskId = (int)($_GET['id'] ?? 0);

        Task::delete($taskId, $userId);

        header("Location: ?route=tasks");
        exit;
    }
}