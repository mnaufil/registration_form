<?php

include "config/database.php";

if (isset($_POST['name'])) {
    $name = trim($_POST['name']);

    try {
        $get_name = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
        $get_name->execute([$name]);
        $fetch_name = $get_name->fetchColumn();

        if ($fetch_name > 0) {
            echo "<span style='color: red;'>Name already exists.</span>";
        } 
    } catch (PDOException $e) {
        echo "<span style='color: red;'>Error checking name.</span>";
    }
}

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    try {
        $get_email = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $get_email->execute([$email]);
        $fetch_email = $get_email->fetchColumn();

        if ($fetch_email > 0) {
            echo "<span style='color: red;'>Email already exists.</span>";
        } 
    } catch (PDOException $e) {
        echo "<span style='color: red;'>Error checking email.</span>";
    }
}

?>
