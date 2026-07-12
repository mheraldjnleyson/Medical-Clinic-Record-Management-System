<?php
require_once "../config/db.php";
requireLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // 1. Data Collection & Validation
        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            throw new Exception("Employee name is required.");
        }

        // Department
        $department = trim($_POST['department'] ?? '');

        $birth_date = $_POST['birth_date'];
        if (!empty($birth_date)) {
            $d = DateTime::createFromFormat('Y-m-d', $birth_date);
            if (!$d || $d->format('Y-m-d') !== $birth_date) {
                throw new Exception("Invalid birth date format.");
            }
            $year = (int) $d->format('Y');
            if ($year < 1900 || $year > date('Y')) {
                throw new Exception("Invalid birth year.");
            }
        } else {
            throw new Exception("Birth date is required.");
        }

        // Other Fields
        $gender = trim($_POST['gender'] ?? '');
        $civil_status = trim($_POST['civil_status'] ?? '');
        $school_district_division = "OCNHS"; // Fixed to OCNHS as per user request
        $position = trim($_POST['position'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $first_year_in_service = trim($_POST['first_year_in_service'] ?? '');

        // Duplicate checks removed as per user request to allow multiple entries with same department/name.


        // 2. Prepare SQL
        $sql = "INSERT INTO employees (department, name, birth_date, gender, civil_status, school_district_division, position, designation, first_year_in_service, entry_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        $stmt->bind_param("sssssssss", $department, $name, $birth_date, $gender, $civil_status, $school_district_division, $position, $designation, $first_year_in_service);

        // 3. Execute
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            logSecurityEvent('EMPLOYEE_ADDED', "Employee: $name (ID: $id) added by User ID: " . $_SESSION['user_id']);

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => true, 'message' => "Employee Record Added Successfully!"]);
                exit;
            }
            $_SESSION['success_message'] = "Employee Record Added Successfully!";
        } else {
            throw new Exception("Error adding record: " . $stmt->error);
        }
        $stmt->close();

    } catch (Exception $e) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
        $_SESSION['error_message'] = $e->getMessage();
    } catch (mysqli_sql_exception $e) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            http_response_code(500); // Server Error
            echo json_encode(['success' => false, 'message' => "Database Error: " . $e->getMessage()]);
            exit;
        }
        $_SESSION['error_message'] = "Database Error: " . $e->getMessage();
    }

    header("Location: " . BASE_PATH . "employees");
    exit();
} else {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['success' => false, 'message' => "Invalid Request Method"]);
        exit;
    }
    header("Location: " . BASE_PATH . "employees");
    exit();
}
?>