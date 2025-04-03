<?php
session_start(); 

include "../config/database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: ../registration.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: ../registration.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../registration.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $profile_image = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../uploads/";
        $profile_image = $target_dir . time() . "_" . basename($_FILES["profile_image"]["name"]);

        $file_size = $_FILES['profile_image']['size'];
        $file_ext = strtolower(pathinfo($profile_image, PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['error'] = "Invalid file type. Allowed: JPG, JPEG, PNG, GIF.";
            header("Location: ../registration.php");
            exit();
        }

        if ($file_size > 3 * 1024 * 1024) {
            $_SESSION['error'] = "File size exceeds 3MB limit.";
            header("Location: ../registration.php");
            exit();
        }


        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image);
    }


    try {
        $stmt = $pdo->prepare("INSERT INTO users (`name`, `email`, `password`, profile_image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password, $profile_image]);
        $_SESSION['success'] = "Registration successful. Please login.";
        header("Location: ../login.php");
        exit();
    } catch (PDOException $e) {
        error_log("[" . date('Y-m-d H:i:s') . "] Registration Error: " . $e->getMessage() . PHP_EOL, 3, "../logs/error.log");
        $_SESSION['error'] = "An error occurred. Please try again.";
        header("Location: ../registration.php");
        exit();
    }


}

?>
