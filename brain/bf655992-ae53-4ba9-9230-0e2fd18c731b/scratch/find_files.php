<?php
$conn = new mysqli('localhost', 'root', '', 'clinic_db');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$res = $conn->query("SELECT filepath FROM student_files LIMIT 1");
if ($res && $row = $res->fetch_assoc()) {
    $dbPath = $row['filepath'];
    echo "DB Path: $dbPath\n";
    
    $searchPaths = [
        __DIR__ . '/../../public/' . $dbPath,
        __DIR__ . '/../../../' . $dbPath,
        'C:/xampp/htdocs/clinic-system/public/' . $dbPath,
        'C:/xampp/htdocs/clinic-system/' . $dbPath
    ];
    
    foreach ($searchPaths as $p) {
        $real = realpath($p);
        echo "Checking: $p -> " . ($real ? "FOUND: $real" : "NOT FOUND") . "\n";
    }
} else {
    echo "No files found in DB.\n";
}
