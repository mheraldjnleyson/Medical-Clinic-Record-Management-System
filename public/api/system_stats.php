<?php
/**
 * System Statistics API
 * Returns basic counts and health stats of the clinic system.
 */
require_once "../../config/db.php";

// Set header to JSON
header('Content-Type: application/json');

// Check authentication
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized access. Please log in.']);
    exit;
}

try {
    $stats = [];

    // 1. Total Students
    $res = $conn->query("SELECT COUNT(*) as total FROM students WHERE is_archived = 0");
    $stats['total_students'] = $res->fetch_assoc()['total'];

    // 2. Total Employees
    $res = $conn->query("SELECT COUNT(*) as total FROM employees WHERE is_archived = 0");
    $stats['total_employees'] = $res->fetch_assoc()['total'];

    // 3. Consultations Today
    $today = date('Y-m-d');
    $res = $conn->query("SELECT COUNT(*) as total FROM treatment_records WHERE DATE(created_at) = '$today'");
    $stats['consultations_today'] = $res ? $res->fetch_assoc()['total'] : 0;

    // 4. Low Stock Inventory Alert (Items with less than 10 quantity)
    $res = $conn->query("SELECT COUNT(*) as total FROM inventory WHERE quantity < 10 AND quantity > 0");
    $stats['low_stock_items'] = $res->fetch_assoc()['total'];

    // 5. System Info
    $stats['server_time'] = date('Y-m-d H:i:s');
    $stats['php_version'] = PHP_VERSION;
    $stats['status'] = 'Operational';

    echo json_encode([
        'success' => true,
        'data' => $stats
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
