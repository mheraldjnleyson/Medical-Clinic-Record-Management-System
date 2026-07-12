<?php
/**
 * Master Data API
 * Returns a comprehensive overview of all modules in the clinic system.
 * Use with caution for large databases.
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
    $masterData = [];

    // 1. STUDENTS (Latest 50)
    $res = $conn->query("SELECT id, name, lrn, gender, curriculum, birth_date FROM students WHERE is_archived = 0 ORDER BY created_at DESC LIMIT 50");
    $masterData['students'] = $res->fetch_all(MYSQLI_ASSOC);

    // 2. EMPLOYEES (Latest 50)
    $res = $conn->query("SELECT id, name, department, position, gender FROM employees WHERE is_archived = 0 ORDER BY created_at DESC LIMIT 50");
    $masterData['employees'] = $res->fetch_all(MYSQLI_ASSOC);

    // 3. OTHERS (Latest 50)
    $res = $conn->query("SELECT id, name, sdo, remarks FROM others WHERE is_archived = 0 ORDER BY created_at DESC LIMIT 50");
    $masterData['others'] = $res->fetch_all(MYSQLI_ASSOC);

    // 4. INVENTORY (All current stock)
    $res = $conn->query("SELECT id, item_name, quantity, unit, expiry_date FROM inventory ORDER BY item_name ASC");
    $masterData['inventory'] = $res->fetch_all(MYSQLI_ASSOC);

    // 5. RECENT TREATMENTS (Latest 20)
    $res = $conn->query("SELECT t.id, t.patient_id, t.patient_type, t.complaint, t.treatment, t.created_at 
                         FROM treatment_records t 
                         ORDER BY t.created_at DESC LIMIT 20");
    $masterData['recent_treatments'] = $res->fetch_all(MYSQLI_ASSOC);

    // 6. SYSTEM USERS (Excluding passwords)
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'superadmin') {
        $res = $conn->query("SELECT id, username, role, full_name, last_login FROM users");
        $masterData['system_users'] = $res->fetch_all(MYSQLI_ASSOC);
    }

    // Metadata
    $response = [
        'success' => true,
        'timestamp' => date('Y-m-d H:i:s'),
        'total_counts' => [
            'students' => $conn->query("SELECT COUNT(*) FROM students WHERE is_archived = 0")->fetch_row()[0],
            'employees' => $conn->query("SELECT COUNT(*) FROM employees WHERE is_archived = 0")->fetch_row()[0],
            'others' => $conn->query("SELECT COUNT(*) FROM others WHERE is_archived = 0")->fetch_row()[0],
            'inventory_items' => $conn->query("SELECT COUNT(*) FROM inventory")->fetch_row()[0],
            'total_treatments' => $conn->query("SELECT COUNT(*) FROM treatment_records")->fetch_row()[0]
        ],
        'data' => $masterData
    ];

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
