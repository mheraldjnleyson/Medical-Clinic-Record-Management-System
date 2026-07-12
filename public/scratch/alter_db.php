<?php
require_once __DIR__ . '/../../config/db.php';
$conn->query("ALTER TABLE inventory_items CHANGE expiry_date expiry_date VARCHAR(50) DEFAULT NULL");
echo "Altered table";
?>
