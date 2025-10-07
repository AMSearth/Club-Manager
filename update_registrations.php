<?php
include 'config.php';

try {
    $pdo->exec("ALTER TABLE registrations ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    $pdo->exec("ALTER TABLE registrations ADD UNIQUE KEY unique_registration (user_id, club_id)");
    echo "Registrations table updated successfully!";
} catch(PDOException $e) {
    if(strpos($e->getMessage(), 'Duplicate column name') !== false || strpos($e->getMessage(), 'Duplicate key name') !== false) {
        echo "Updates already applied.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
