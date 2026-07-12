<?php
require 'config/db.php';
$r = $conn->query('DESCRIBE users');
while($row = $r->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}
