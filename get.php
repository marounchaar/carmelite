<?php
include 'connect.php';

$sql = "SELECT * FROM carm";
$result = $conn->query($sql);

$records = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // Decode uni_dip JSON
        if (!empty($row['uni_dip'])) {
            $row['uni_dip'] = json_decode($row['uni_dip'], true);
        } else {
            $row['uni_dip'] = [];
        }

        // Decode members JSON
        if (!empty($row['members'])) {
            $row['members'] = json_decode($row['members'], true);
        } else {
            $row['members'] = [];
        }

        // Convert occupation (comma-separated values) into an array
        if (!empty($row['occupation'])) {
            $row['occupation'] = explode(',', $row['occupation']);
        } else {
            $row['occupation'] = [];
        }

        $records[] = $row;
    }
}

$conn->close();
?>
