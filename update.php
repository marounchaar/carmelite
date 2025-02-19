<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $f_name = $_POST['f_name'];
    $m_name = $_POST['m_name'];
    $l_name = $_POST['l_name'];
    $birth_date = $_POST['birth_date'];
    $phone_number = $_POST['phone_number'];
    $other_number = $_POST['other_number'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $school = $_POST['school'];
    $entry_year = $_POST['entry_year'];
    $final_year = $_POST['final_year'];
    $grad_year = $_POST['grad_year'];
    $career = $_POST['career'];
    $position = $_POST['position'];
    $company = $_POST['company'];
    $message = $_POST['message'];
    $sibilings = $_POST['sibilings'];





    $occupation = isset($_POST['occupation']) ? implode(',', $_POST['occupation']) : '';

    $uni_dip = [];
    if (!empty($_POST['university']) && !empty($_POST['diploma'])) {
        foreach ($_POST['university'] as $key => $university) {
            $diploma = $_POST['diploma'][$key] ?? "";
            if (!empty($university) || !empty($diploma)) {
                $uni_dip[] = ['university' => $university, 'diploma' => $diploma];
            }
        }
    }
    $uni_dip_json = !empty($uni_dip) ? json_encode($uni_dip) : NULL;


    $members = [];
    if (!empty($_POST['name']) && !empty($_POST['e_mail']) && !empty($_POST['mobile_phone'])) {
        foreach ($_POST['name'] as $key => $name) {
            $e_mail = $_POST['e_mail'][$key] ?? "";
            $mobile_phone = $_POST['mobile_phone'][$key] ?? "";
            if (!empty($name) || !empty($e_mail) || !empty($mobile_phone)) {
                $members[] = ['name' => $name, 'e_mail' => $e_mail, 'mobile_phone' => $mobile_phone];
            }
        }
    }
    $members_json = !empty($members) ? json_encode($members) : NULL;




    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    $query = "SELECT fid_path, bid_path, id_path FROM carm WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fid_path, $bid_path, $id_path);
    $stmt->fetch();
    $stmt->close();
    
    // Function to upload files to the correct subdirectory
    function uploadFile($file, $existing_file_path, $folder) {
        if (isset($file) && $file['error'] == 0) {
            $upload_dir = "uploads/$folder/";
    
            // Ensure the directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
    
            // Delete the old file if it exists
            if (!empty($existing_file_path) && file_exists($existing_file_path)) {
                unlink($existing_file_path);
            }
    
            // Generate a unique name to avoid overwriting
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid('file_', true) . '.' . $file_extension;
            $new_path = $upload_dir . $new_filename;
    
            // Move the file to the correct folder
            if (move_uploaded_file($file['tmp_name'], $new_path)) {
                return $new_path; // Return the new file path
            }
        }
        return $existing_file_path; // Return the old file path if no new file was uploaded
    }
    
    // Upload files to their respective directories
    $fid_file_path = uploadFile($_FILES['file1'], $fid_path, "fid_files");
    $bid_file_path = uploadFile($_FILES['file2'], $bid_path, "bid_files");
    $id_file_path = uploadFile($_FILES['file3'], $id_path, "id_files");


    ///////////////////////////////////////////////////////////////////////////////////////////////////////


    $sql = "UPDATE carm SET 
    f_name = ? , m_name = ?, l_name = ?, 
    birth_date = ?, phone_number = ?, other_number = ?,
    gender = ? , nationality = ?, city = ? , 
    street = ? , building = ? , floor = ? , 
    email = ? , number = ? , school = ? ,
     occupation = ? , uni_dip = ? , entry_year = ? , 
     final_year = ? , grad_year = ? , career = ? , 
     position = ? , company = ? , message = ? , 
     sibilings = ? , members = ? , fid_path = ? , 
     bid_path = ? , id_path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiisssssssisssiiisssssssssi",
     $f_name, $m_name, $l_name, 
     $birth_date, $phone_number, $other_number,
      $gender, $nationality, $city, 
      $street, $building, $floor , 
      $email, $number, $school, 
      $occupation, $uni_dip_json, $entry_year, 
      $final_year, $grad_year, $career,
      $position, $company, $message, 
      $sibilings, $members_json, $fid_file_path, 
      $bid_file_path, $id_file_path, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully!";
        header("Location: display.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>
