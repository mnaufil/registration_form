<?php
session_start(); 

require_once "../config/database.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Validate inputs
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Email and Password are required.";
        header("Location: ../login.php");
        exit();
    }

    // Sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        // Fetch user from database
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Ensure password is hashed in the database before verifying
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['success'] = "Welcome, " . $user['name'] . "!";

            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: ../login.php");
            exit();
        }

    } catch (PDOException $e) {
        // Log the error
        error_log("[" . date('Y-m-d H:i:s') . "] Login Error: " . $e->getMessage() . PHP_EOL, 3, "../logs/error.log");

        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: ../login.php");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
