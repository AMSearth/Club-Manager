<?php
include 'config.php';
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$event_id = $_GET['id'];

// Add event_registrations table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS event_registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        event_id INT,
        UNIQUE KEY unique_event_registration (user_id, event_id),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (event_id) REFERENCES events(id)
    )");
} catch(PDOException $e) {}

// Check if already registered
$stmt = $pdo->prepare("SELECT * FROM event_registrations WHERE user_id = ? AND event_id = ?");
$stmt->execute([$_SESSION['user_id'], $event_id]);
if($stmt->fetch()) {
    header('Location: index.php?msg=event_already_registered');
    exit;
}

$stmt = $pdo->prepare("INSERT INTO event_registrations (user_id, event_id) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $event_id]);

header('Location: index.php?msg=event_registered');
?>
