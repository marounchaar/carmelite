<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT fid_path, bid_path, id_path FROM carm WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($fid_path, $bid_path, $id_path);
        $stmt->fetch();


        if (!empty($fid_path)) {
            unlink( $fid_path);
        }
        if (!empty($bid_path)) {
            unlink( $bid_path); 
        }
        if (!empty($id_path)) {
            unlink( $id_path); 
        }

        // Delete the record from the database
        $deleteStmt = $conn->prepare("DELETE FROM carm WHERE id = ?");
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            header("Location: display.php?message=Record and associated photos deleted successfully");
        } else {
            echo "Error deleting record: " . $deleteStmt->error;
        }

        $deleteStmt->close();
    } else {
        echo "Record not found.";
    }
} else {
    header("Location: display.php?message=No record selected for deletion");
}

$conn->close();
?>
