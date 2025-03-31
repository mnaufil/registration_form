<?php 

$host = "localhost";
$dbname = "nec";
$username = "root";
$password = "";

//for logging error
$logFile = "../logs/error.log";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    
    error_log("[" . date('Y-m-d H:i:s') . "] Database Connection Failed: " . $e->getMessage() . PHP_EOL, 3, $logFile);

    session_start();
    $_SESSION['error'] = "Database connection failed! Please try again later.";

    header("Location: registration.php");
    exit();
}

?>