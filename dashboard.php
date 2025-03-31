<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first.";
    header("Location: login.php");
    exit();
}

// Logout handling
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center text-primary">Welcome, <?= $user_name ?></h2>
        <p class="text-center text-muted">You have successfully logged in.</p>

        <div class="text-center mt-4">
            <a href="dashboard.php?logout=true" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
