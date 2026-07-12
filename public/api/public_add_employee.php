<?php
require_once "../../config/db.php";

// Set JSON response header
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // 1. Rate Limiting (Prevent Spam - Max 3 per hour from same IP)
        $rateLimit = checkRateLimit('public_registration_employee', 3, 3600);
        if (!$rateLimit['allowed']) {
            throw new Exception("Too many registration attempts. Please try again in " . $rateLimit['wait'] . " seconds.");
        }

        // 2. CSRF Verification
        if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
            throw new Exception("Security token mismatch. Please refresh the page.");
        }

        // 3. Input Validation
        $required_fields = ['last_name', 'first_name', 'gender', 'birth_date', 'civil_status', 'position', 'designation', 'school_district_division', 'first_year_in_service'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        // 2. Validate Date
        $birth_date = sanitizeInput($_POST['birth_date']);
        $d = DateTime::createFromFormat('Y-m-d', $birth_date);
        if (!$d || $d->format('Y-m-d') !== $birth_date) {
            throw new Exception("Invalid date format. Please use YYYY-MM-DD.");
        }

        $year = (int) $d->format('Y');
        if ($year < 1900 || $year > date('Y')) {
            throw new Exception("Invalid birth year. Please enter a valid date.");
        }

        // 3. Format Name: Last, First Middle
        $middle = isset($_POST['middle_name']) ? sanitizeInput($_POST['middle_name']) : '';
        $name = sanitizeInput($_POST['last_name']) . ", " . sanitizeInput($_POST['first_name']) . ($middle ? " " . $middle : "");

        // 4. Prepare SQL
        $sql = "INSERT INTO employees (name, department, birth_date, gender, civil_status, position, designation, school_district_division, first_year_in_service, entry_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        // Bind Parameters
        $department = isset($_POST['department']) ? sanitizeInput($_POST['department']) : '';
        $gender = sanitizeInput($_POST['gender']);
        $civil_status = sanitizeInput($_POST['civil_status']);
        $position = sanitizeInput($_POST['position']);
        $designation = sanitizeInput($_POST['designation']);
        $school_district_division = "OCNHS"; // Fixed to OCNHS as per user request
        $first_year_in_service = (int) sanitizeInput($_POST['first_year_in_service']);

        // Duplicate checks removed as per user request to allow multiple entries with same department/name.


        $stmt->bind_param(
            "ssssssssi",
            $name,
            $department,
            $birth_date,
            $gender,
            $civil_status,
            $position,
            $designation,
            $school_district_division,
            $first_year_in_service
        );

        if ($stmt->execute()) {
            // Create a notification for the admin
            $notifMsg = "New public employee registration: " . $name;
            $notifLink = "employees.php?search=" . urlencode($name);
            $stmtNotif = $conn->prepare("INSERT INTO notifications (type, message, link) VALUES ('registration', ?, ?)");
            if ($stmtNotif) {
                $stmtNotif->bind_param("ss", $notifMsg, $notifLink);
                $stmtNotif->execute();
                $stmtNotif->close();
            }

            echo json_encode(['success' => true, 'message' => "Employee registered successfully!"]);
        } else {
            throw new Exception("Error saving employee. Please try again later.");
        }
        $stmt->close();

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Database error occurred. Please contact administrator."]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => "Method Not Allowed"]);
}
?>