<?php
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = escape($_POST['complaint_id']);
    $status = escape($_POST['status']);
    $remark = escape($_POST['remark']);

    // Update complaint record
    $stmt = $conn->prepare("UPDATE complaints SET status = ?, admin_remark = ? WHERE complaint_id = ?");
    $stmt->bind_param("sss", $status, $remark, $complaint_id);
    
    if ($stmt->execute()) {
        // Insert into history log
        $hist_stmt = $conn->prepare("INSERT INTO status_history (complaint_id, status, remark) VALUES (?, ?, ?)");
        $hist_stmt->bind_param("sss", $complaint_id, $status, $remark);
        $hist_stmt->execute();
        
        // Redirect back to the view page
        $id_query = $conn->query("SELECT id FROM complaints WHERE complaint_id = '$complaint_id'");
        if($row = $id_query->fetch_assoc()){
            header("Location: view_complaint.php?id=" . $row['id'] . "&success=1");
            exit();
        }
    }
}

header("Location: complaints.php");
exit();
