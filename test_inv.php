<?php
session_start();
require_once 'config/db.php';
$res = $conn->query("SELECT session_token FROM users WHERE id = 2");
$row = $res->fetch_assoc();
$_SESSION['user_id'] = 2;
$_SESSION['username'] = 'admin';
$_SESSION['role'] = 'admin';
$_SESSION['session_token'] = $row['session_token'];

// Now include public/inventory.php
ob_start();
chdir('public');
include 'inventory.php';
$output = ob_get_clean();
echo "Execution completed! Length: " . strlen($output) . "\n";
if (empty($output)) {
    echo "Warning: Output is empty!\n";
} else {
    echo "First 500 chars of output:\n" . substr($output, 0, 500) . "\n";
}
?>
