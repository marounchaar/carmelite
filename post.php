<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'connect.php';
require 'vendor/autoload.php'; // Include PHPMailer's autoload file (if using Composer)

// Process POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form Fields
    $fields = [
        'f_name', 'm_name', 'l_name', 'birth_date', 'phone_number', 'other_number', 
        'gender', 'nationality', 'residence_country', 'governorate', 'casa', 
        'city', 'street', 'building', 'floor', 'email', 'number', 'school', 
        'occupation', 'entry_year', 'final_year', 'grad_year', 'career', 'position', 
        'company', 'sibilings', 'message'
    ];
    foreach ($fields as $field) {
        $$field = !empty($_POST[$field]) ? $_POST[$field] : null;
    }
    $occupation = isset($_POST['occupation']) ? implode(", ", $_POST['occupation']) : "";
    $sibilings = isset($_POST['sibilings']) ? $_POST['sibilings'] : null;

    // Handle university and diploma fields
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

    // Handle members fields
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

    // File upload handler
    function handleFileUpload($fileKey, $uploadDir) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
            $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
            $fileName = $_FILES[$fileKey]['name'];
            $fileSize = $_FILES[$fileKey]['size'];
            $fileType = $_FILES[$fileKey]['type'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; 
            $maxFileSize = 10 * 1024 * 1024; 

            if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
                $f_name = $_POST['f_name'];
                $fileNewName = uniqid('file_', true) . $f_name . date('Y-m-d');
                $uploadFolder = $uploadDir;
                if (!is_dir($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }
                $fileDestination = $uploadFolder . $fileNewName;
                if (move_uploaded_file($fileTmpPath, $fileDestination)) {
                    return $fileDestination; 
                } else {
                    echo "Error uploading file: " . $fileName;
                }
            } else {
                echo "Invalid file type or file size exceeded for: " . $fileName;
            }
        }
        return null;
    }

    $fid_path = handleFileUpload('file1', 'uploads/fid_files/');
    $bid_path = handleFileUpload('file2', 'uploads/bid_files/');
    $id_path = handleFileUpload('file3', 'uploads/id_files/');

    // Check if email or phone number already exists in the database
    $checkStmt = $conn->prepare("SELECT COUNT(*) AS count FROM carm WHERE email = ? OR phone_number = ?");
    $checkStmt->bind_param("ss", $email, $phone_number);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Email or phone number already exists
        echo "Error: The provided email or phone number already exists in the database.";
    } else {
        // Proceed with inserting the data
        $stmt = $conn->prepare("INSERT INTO carm (f_name, m_name, l_name, birth_date, phone_number, other_number, gender, nationality, residence_country, governorate, casa, city, street, building, floor, email, number, school, occupation, entry_year, final_year, grad_year, career, position, company, sibilings, message, uni_dip, members, fid_path, bid_path, id_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssiissssssssssissiiissssssssss", $f_name, $m_name, $l_name, $birth_date, $phone_number, $other_number, $gender, $nationality, $residence_country, $governorate, $casa, $city, $street, $building, $floor, $email ,$number, $school, $occupation, $entry_year, $final_year, $grad_year, $career, $position, $company, $sibilings, $message, $uni_dip_json, $members_json, $fid_path, $bid_path, $id_path);

        if ($stmt->execute()) {
            // Send email after successful form submission
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = ''; // SMTP email
            $mail->Password = ''; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('marounchaar99@gmail.com', 'Maroun Chaar');
            $mail->addAddress($email); // User's email address
            $mail->addReplyTo('marounchaar99@gmail.com', 'Maroun Chaar');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation Email';
            $mail->Body    = '<h1>Thank you ' .  $f_name . ' for your submission!</h1><p>Your data has been successfully submitted.</p>';

            // Send the email and check for success
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                // Redirect or success message
                header("Location: index.php?success=true");
                exit();
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
}
?>