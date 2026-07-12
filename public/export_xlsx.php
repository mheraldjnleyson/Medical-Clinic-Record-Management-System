<?php
ob_start();
require_once "../config/db.php";
requireLogin();

$type = isset($_GET['type']) ? $_GET['type'] : 'student';
$is_archived = isset($_GET['archived']) ? 1 : 0;
$filename = ($is_archived ? "archived_" : "") . $type . "_records_" . date('Y-m-d') . ".xls";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $filename . '"');

if ($type == 'drug_log') {
    $startDate = $_GET['start'] ?? date('Y-m-01');
    $endDate = $_GET['end'] ?? date('Y-m-t');
    $searchMed = $_GET['search'] ?? '';

    function extractLogs($res, $pType, $pIdentKey, $startDate, $endDate, $searchMed)
    {
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $logs = json_decode($row['treatment_logs_json'] ?? '[]', true);
            foreach ($logs as $log) {
                $d = $log['date'] ?? '';
                if ($d >= $startDate && $d <= $endDate) {
                    $slots = [
                        ['p' => $log['plan'] ?? ($log['treatment'] ?? ''), 'q' => $log['quantity'] ?? 1, 'a' => $log['attended'] ?? 'Staff'],
                        ['p' => $log['plan2'] ?? '', 'q' => $log['quantity2'] ?? 1, 'a' => $log['attended2'] ?? 'Staff'],
                        ['p' => $log['plan3'] ?? '', 'q' => $log['quantity3'] ?? 1, 'a' => $log['attended3'] ?? 'Staff']
                    ];
                    foreach ($slots as $s) {
                        $med = trim($s['p']);
                        if ($med) {
                            if ($searchMed && stripos($med, $searchMed) === false && stripos($row['name'], $searchMed) === false)
                                continue;
                            $data[] = ['date' => $d, 'name' => $row['name'], 'id' => $row[$pIdentKey] ?? 'N/A', 'type' => $pType, 'med' => $med, 'qty' => $s['q'], 'att' => $s['a']];
                        }
                    }
                }
            }
        }
        return $data;
    }

    $drugLogs = [];
    $drugLogs = array_merge($drugLogs, extractLogs($conn->query("SELECT name, lrn, treatment_logs_json FROM students WHERE is_archived=0"), 'Student', 'lrn', $startDate, $endDate, $searchMed));
    $drugLogs = array_merge($drugLogs, extractLogs($conn->query("SELECT name, department, treatment_logs_json FROM employees WHERE is_archived=0"), 'Employee', 'department', $startDate, $endDate, $searchMed));
    $drugLogs = array_merge($drugLogs, extractLogs($conn->query("SELECT name, treatment_logs_json FROM others WHERE is_archived=0"), 'Other', 'name', $startDate, $endDate, $searchMed));
    usort($drugLogs, fn($a, $b) => strcmp($b['date'], $a['date']));

    echo "DATE\tPATIENT NAME\tID\tCATEGORY\tMEDICINE\tQTY\tATTENDED BY\n";
    foreach ($drugLogs as $row) {
        echo $row['date'] . "\t" . strtoupper($row['name']) . "\t" . strtoupper($row['id']) . "\t" . strtoupper($row['type']) . "\t" . strtoupper($row['med']) . "\t" . $row['qty'] . "\t" . strtoupper($row['att']) . "\n";
    }
} else {
    // Original Logic
    $table = 'students';
    if ($type == 'employee')
        $table = 'employees';
    elseif ($type == 'inventory')
        $table = 'inventory_items';
    elseif ($type == 'others')
        $table = 'others';

    if ($type == 'inventory') {
        $result = $conn->query("SELECT * FROM inventory_items WHERE is_archived = $is_archived ORDER BY name ASC");
        $categories = ['Medicine', 'Medical Supply', 'Equipment'];
        $invData = [];
        while ($row = $result->fetch_assoc()) {
            $invData[$row['category']][] = $row;
        }
        foreach ($categories as $cat) {
            if (empty($invData[$cat]))
                continue;
            echo strtoupper($cat) . "\n";
            $headerDateCondition = ($cat === 'Equipment') ? 'CONDITION' : 'EXPIRY DATE';
            echo "ITEM NAME\tDESCRIPTION\tSTOCK LEVEL\tUNIT\t{$headerDateCondition}\tSTATUS\n";
            foreach ($invData[$cat] as $row) {
                $status = "AVAILABLE";
                if ($row['quantity'] == 0)
                    $status = "OUT OF STOCK";
                elseif ($cat !== 'Equipment' && $row['expiry_date'] && new DateTime($row['expiry_date']) < new DateTime('today'))
                    $status = "EXPIRED";
                elseif ($row['quantity'] <= ($row['reorder_level'] ?? 10))
                    $status = "LOW STOCK";

                $dateConditionVal = ($cat === 'Equipment') ? strtoupper($row['expiry_date']) : strtoupper($row['expiry_date']);
                echo strtoupper($row['name']) . "\t" . strtoupper($row['description']) . "\t" . $row['quantity'] . "\t" . strtoupper($row['unit']) . "\t" . $dateConditionVal . "\t" . $status . "\n";
            }
            echo "\n";
        }
    } else {
        if ($type == 'student') {
            echo "NAME\tLRN\tCURRICULUM\tAGE\tADDRESS\tGENDER\tBIRTH DATE\tBIRTHPLACE\tRELIGION\tGUARDIAN\tCONTACT\n";
        } elseif ($type == 'others') {
            echo "NAME\tAGE\tSDO\tGENDER\tADDRESS\tREMARKS\tBIRTH DATE\n";
        } else {
            echo "NAME\tPOSITION\tDESIGNATION\tAGE\tGENDER\tBIRTH DATE\tCIVIL STATUS\n";
        }

        $result = $conn->query("SELECT * FROM $table WHERE is_archived = $is_archived ORDER BY name ASC");
        while ($row = $result->fetch_assoc()) {
            if ($type == 'student') {
                $age = '-';
                if ($row['birth_date']) {
                    $birth = new DateTime($row['birth_date']);
                    $age = $birth->diff(new DateTime('today'))->y;
                }
                echo strtoupper($row['name']) . "\t" . strtoupper($row['lrn']) . "\t" . strtoupper($row['curriculum']) . "\t" . $age . "\t" . strtoupper($row['address']) . "\t" . strtoupper($row['gender']) . "\t" . $row['birth_date'] . "\t" . strtoupper($row['birthplace']) . "\t" . strtoupper($row['religion']) . "\t" . strtoupper($row['guardian']) . "\t" . strtoupper($row['contact']) . "\n";
            } elseif ($type == 'others') {
                $age = '-';
                if ($row['birth_date']) {
                    $age = (new DateTime($row['birth_date']))->diff(new DateTime('today'))->y;
                } else {
                    $age = $row['age'] ?: '-';
                }
                echo strtoupper($row['name']) . "\t" . $age . "\t" . strtoupper($row['sdo']) . "\t" . strtoupper($row['gender']) . "\t" . strtoupper($row['address']) . "\t" . strtoupper($row['remarks']) . "\t" . $row['birth_date'] . "\n";
            } else {
                $age = '-';
                if ($row['birth_date']) {
                    $age = (new DateTime($row['birth_date']))->diff(new DateTime('today'))->y;
                }
                echo strtoupper($row['name']) . "\t" . strtoupper($row['position']) . "\t" . strtoupper($row['designation']) . "\t" . $age . "\t" . strtoupper($row['gender']) . "\t" . $row['birth_date'] . "\t" . strtoupper($row['civil_status']) . "\n";
            }
        }
    }
}
exit;