<?php

namespace App\Models;

use App\Database;
use PDO;

class User
{
    public static function create(string $name, string $email, string $password): bool
    {
        $pdo = Database::connect();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ");

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public static function findByEmail(string $email)
    {
        $pdo = Database::connect();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public static function findById(int $id)
    {
        $pdo = Database::connect();
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}