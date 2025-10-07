<?php
include 'config.php';

try {
    $pdo->exec("ALTER TABLE users ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    $pdo->exec("UPDATE users SET status = 'approved' WHERE role = 'admin'");
    echo "Users table updated successfully!";
} catch(PDOException $e) {
    if(strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Updates already applied.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
