<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function showRegisterForm()
    {
        echo '
        <h2>Register</h2>
        <form method="POST" action="?route=register">
            <input type="text" name="name" placeholder="Name" required><br><br>
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Register</button>
        </form>
        ';
    }

    public function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$name || !$email || !$password) {
            echo "All fields are required.";
            return;
        }

        if (User::findByEmail($email)) {
            echo "Email already exists.";
            return;
        }

        User::create($name, $email, $password);

        echo "User registered successfully!";
    }

    public function showLoginForm()
    {
        echo '
        <h2>Login</h2>
        <form method="POST" action="?route=login">
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
        ';
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            echo "Invalid credentials.";
            return;
        }

        // Store user in session
        $_SESSION['user_id'] = $user['id'];

        echo "Login successful! <br>";
        echo '<a href="?route=dashboard">Go to Dashboard</a>';
    }

    public function logout()
    {
    session_destroy();
    header("Location: ?route=login");
    exit;
    }
}