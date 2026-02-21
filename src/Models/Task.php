<?php

namespace App\Models;

use App\Database;
use PDO;

class Task
{
    public static function create(int $userId, string $title, string $description): bool
    {
        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            INSERT INTO tasks (user_id, title, description)
            VALUES (:user_id, :title, :description)
        ");

        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description
        ]);
    }

    public static function allByUser(int $userId)
    {
        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            SELECT * FROM tasks WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");

        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function markCompleted(int $taskId, int $userId)
    {
        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            UPDATE tasks
            SET is_completed = 1
            WHERE id = :id AND user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $taskId,
            'user_id' => $userId
        ]);
    }

    public static function delete(int $taskId, int $userId)
    {
        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            DELETE FROM tasks
            WHERE id = :id AND user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $taskId,
            'user_id' => $userId
        ]);
    }
}