<?php

session_start(); // Start the session if not already started
include './config/base.php';
include './config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/PHPMailer/src/Exception.php';
require './vendor/PHPMailer/src/PHPMailer.php';
require './vendor/PHPMailer/src/SMTP.php';

// Assuming a connection to the database has already been established

function uploadFiles($pdo, $uploadedFiles)
{
    set_time_limit(30); // Set the maximum execution time to 30 seconds
    try {
        $fillable = ['ip_address', 'stage', 'scope_of_work', 'floor_plan', 'trust', 'name', 'phone', 'email']; // Define fillable columns
        $data = [];

        foreach ($fillable as $field) {
            $data[$field] = $_POST[$field] ?? null; // Set to null if not provided
        }

        $ipAddress = $data['ip_address'] ?? $_SERVER['REMOTE_ADDR']; // Get the user's IP address
        $stage = $data['stage'] ?? 1; // Get stage from POST data, default to 1
        $scopeOfWork = $data['scope_of_work'] ?? ''; // Get scope of work from POST data
        $floorPlan = $data['floor_plan'] ?? 0; // Get floor plan from POST data, default to 0
        $trust = $data['trust'] ?? 0; // Get trust from POST data, default to 0
        $name = $data['name'] ?? null; // Get name from POST data
        $phone = $data['phone'] ?? null; // Get phone from POST data
        $email = $data['email'] ?? null; // Get email from POST data

        // Check for existing data associated with the IP address
        $existingData = findDataByIpAddress($pdo, $ipAddress);

        // If existing data is found, update it instead of inserting a new record
        if (!empty($existingData)) {
            $uploadId = $existingData[0]['id']; // Use the existing upload ID

            $ipAddress = $_POST['ip_address'] ?? $existingData[0]['ip_address'] ?? $ipAddress;
            $stage = $_POST['stage'] ?? $existingData[0]['stage'] ?? $stage;
            $scopeOfWork = $_POST['scope_of_work'] ?? $existingData[0]['scope_of_work'] ?? $scopeOfWork;
            $floorPlan = $_POST['floor_plan'] ?? $existingData[0]['floor_plan'] ?? $floorPlan;
            $trust = $_POST['trust'] ?? $existingData[0]['trust'] ?? $trust;
            $name = $_POST['name'] ?? $existingData[0]['name'] ?? $name;
            $phone = $_POST['phone'] ?? $existingData[0]['phone'] ?? $phone;
            $email = $_POST['email'] ?? $existingData[0]['email'] ?? $email;

            $stmt = $pdo->prepare("UPDATE upload SET stage = ?, scope_of_work = ?, floor_plan = ?, trust = ?, name = ?, phone = ?, email = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$stage, $scopeOfWork, $floorPlan, $trust, $name, $phone, $email, $uploadId]);
        } else {
            // Check if the existing data stage is greater than the posted stage
            if (!empty($existingData) && $existingData[0]['stage'] > $stage) {
                $stage = $existingData[0]['stage']; // Use the existing stage
            }

            // Prepare the SQL statement to insert data into the upload table
            $stmt = $pdo->prepare("INSERT INTO upload (ip_address, stage, scope_of_work, floor_plan, trust, name, phone, email, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$ipAddress, $stage, $scopeOfWork, $floorPlan, $trust, $name, $phone, $email]);
            $uploadId = $pdo->lastInsertId(); // Get the last inserted ID
        }

        // Prepare the SQL statement for file uploads
        $fileStmt = $pdo->prepare("INSERT INTO upload_files (upload_id, stage, file, created_at) VALUES (?, ?, ?, NOW())");
        $status = false; // Initialize status

        if (isset($_FILES) && isset($_FILES['files'])) {
            $uploadedFiles = $_FILES['files'];
            $fileCount = count($uploadedFiles['name']);
            $status = true; // Set status to true if files are present

            for ($i = 0; $i < $fileCount; $i++) {
                if ($uploadedFiles['error'][$i] === UPLOAD_ERR_OK) {
                    $fileExtension = pathinfo($uploadedFiles['name'][$i], PATHINFO_EXTENSION);
                    $randomFileName = bin2hex(random_bytes(5)) . '.' . $fileExtension; // Generate a random file name with 5 length

                    // Move the uploaded file to a designated directory (optional)
                    $targetDirectory = 'uploads/'; // Ensure this directory exists and is writable
                    if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $targetDirectory . $randomFileName)) {
                        // Execute the prepared statement for file uploads
                        $fileStmt->execute([$uploadId, $stage, $randomFileName]);
                    } else {
                        return ["status" => false, "message" => "Error moving uploaded file."];
                    }
                } else {
                    return ["status" => false, "message" => "Error uploading file: " . $uploadedFiles['error'][$i]];
                }
            }
        }

        if (isset($_POST['removed_files'])) {
            $removedFiles = json_decode($_POST['removed_files']);
            if (count($removedFiles) > 0) {
                $fileStmtDelete = $pdo->prepare("DELETE FROM upload_files WHERE id IN (" . implode(',', array_map('intval', $removedFiles)) . ")");
                $fileStmtDelete->execute();
            }
        }
        // Always pending
        $to = "yaelahman0810@gmail.com"; // Recipient's email
        $subject = "Evolution - New Consultation";
        $message = "
        <html>
        <head>
            <title>New Consultation</title>
            <style>
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 4px; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h2>Consultation Details</h2>
            <table>
                <tr><th>Name</th><td>$name</td></tr>
                <tr><th>Phone</th><td>$phone</td></tr>
                <tr><th>Email</th><td>$email</td></tr>
                <tr><th>Scope of Work</th><td>$scopeOfWork</td></tr>
                <tr><th>No Floor Plans</th><td>" . ($floorPlan == 1 ? 'Yes' : 'No') . "</td></tr>
                <tr><th>Trust Choice</th><td>" . ($trust == 1 ? 'Yes' : 'No') . "</td></tr>
            </table>
        </body>
        </html>";

        // Fetch all uploaded files for the email
        $fileStmt = $pdo->prepare("SELECT file, stage FROM upload_files WHERE upload_id = ?");
        $fileStmt->execute([$uploadId]);
        $files = $fileStmt->fetchAll(PDO::FETCH_ASSOC);

        // Set your email configuration
        $fromEmail = "support@synnmlbb.com"; // Change to your domain
        $headers = "From: $fromEmail"; // Use the configured email

        // SMTP configuration
        $smtpHost = 'smtp.gmail.com'; // Your SMTP server
        $smtpPort = 587; // Changed to 587 for TLS
        $smtpUser = 'ytbprem0810@gmail.com'; // Your SMTP username
        $smtpPass = 'qvosijthbrtqmhoa'; // Your SMTP password

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Changed to use TLS encryption
        $mail->Port = $smtpPort;

        $mail->setFrom($fromEmail);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true); // Set email format to HTML
        $mail->Body = nl2br($message); // Convert new lines to HTML line breaks

        if (!empty($files)) {
            foreach ($files as $file) {
                $fileName = '';
                if ($file['stage'] == 1) {
                    $fileName = "Scope of Work";
                } elseif ($file['stage'] == 2) {
                    $fileName = "Floor Plans";
                } elseif ($file['stage'] == 3) {
                    $fileName = "Inspiration Photos";
                }
                $mail->addAttachment("./uploads/" . basename($file['file']), $fileName . "." . explode('.', $file['file'])[1]); // Add attachments
            }
        }

       if ($stage == 4) {
        if (!$mail->send()) {
            throw new Exception("Could not connect to SMTP host. Failed to connect to server: " . $mail->ErrorInfo);
        }

        try {
            if (!$mail->send()) {
                throw new Exception("Failed to send email to $to. Error: " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
       }

        return ["status" => true, "message" => "Files uploaded successfully!", "nextStage" => BASE_URL . "app/index.php?step=" . ($stage + 1)];
    } catch (\Exception $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadedFiles = $_FILES['files'] ?? [];
    echo json_encode(uploadFiles($pdo, $uploadedFiles));
}

function findDataByIpAddress($pdo, $ipAddress)
{
    $_SESSION['ip_address'] = $ipAddress; // Set the session variable for IP address
    // Prepare the SQL statement to select data by IP address
    $stmt = $pdo->prepare("SELECT u.*, uf.file, uf.id as files_id, uf.stage as files_stage FROM upload u LEFT JOIN upload_files uf ON u.id = uf.upload_id WHERE u.ip_address = ? AND u.stage < 5");
    $stmt->execute([$ipAddress]);

    // Fetch all results
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $resultData = [];
    if ($result) {
        $resultData = $result[0];
        $resultData['files'] = [];
    }

    // Organize files into a separate 'files' key in the result
    $data = [];
    foreach ($result as $row) {
        $data[] = [
            ...$row,
            'files' => []
        ];
        if (!empty($row['file'])) {
            $resultData['files'][] = [
                'id' => $row['files_id'],
                'file' => $row['file'],
                'stage' => $row['files_stage']
            ];
        }
    }

    return $resultData ? [$resultData] : [];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ip_address'])) {
    $ipAddress = $_GET['ip_address'];
    $data = findDataByIpAddress($pdo, $ipAddress);
    echo json_encode($data);
}
