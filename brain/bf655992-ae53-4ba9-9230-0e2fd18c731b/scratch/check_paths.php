<?php
$conn = new mysqli('localhost', 'root', '', 'clinic_db');
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

echo "Student Files:\n";
$res = $conn->query("SELECT filepath FROM student_files LIMIT 10");
if ($res)
    while ($row = $res->fetch_assoc())
        echo $row['filepath'] . "\n";

echo "\nEmployee Files:\n";
$res = $conn->query("SELECT filepath FROM employee_files LIMIT 10");
if ($res)
    while ($row = $res->fetch_assoc())
        echo $row['filepath'] . "\n";

echo "\nStudents Consent:\n";
$res = $conn->query("SELECT name, consent_front_file, consent_back_file FROM students WHERE consent_front_file IS NOT NULL OR consent_back_file IS NOT NULL LIMIT 10");
if ($res)
    while ($row = $res->fetch_assoc()) {
        echo $row['name'] . ": " . $row['consent_front_file'] . " | " . $row['consent_back_file'] . "\n";
    }
