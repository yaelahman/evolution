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

        // Forward data to email when stage is 4
        if ($stage == 4) {
            $to = "yaelahman0810@gmail.com"; // Recipient's email
            $subject = "Project Submission - Stage 4";
            $message = "Name: $name\nPhone: $phone\nEmail: $email\nScope of Work: $scopeOfWork\nFloor Plan: $floorPlan\nTrust: $trust\n\nUploaded Files:\n";

            // Fetch all uploaded files for the email
            $fileStmt = $pdo->prepare("SELECT file FROM upload_files WHERE upload_id = ?");
            $fileStmt->execute([$uploadId]);
            $files = $fileStmt->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($files)) {
                foreach ($files as $file) {
                    $message .= "- $file\n"; // Append each file to the message
                }
            } else {
                $message .= "No files uploaded.\n";
            }

            // Set your email configuration
            $fromEmail = "no-reply@yourdomain.com"; // Change to your domain
            $headers = "From: $fromEmail"; // Use the configured email

            // SMTP configuration
            $smtpHost = 'mail.synnmlbb.com'; // Your SMTP server
            $smtpPort = 465; // Your SMTP port (usually 587 for TLS or 465 for SSL)
            $smtpUser = 'no-reply@synnmlbb.com'; // Your SMTP username
            $smtpPass = 'GHe19giTvMGMi'; // Your SMTP password


            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
            $mail->Port = $smtpPort;

            $mail->setFrom($fromEmail);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if (!$mail->send()) {
                error_log("Failed to send email to $to. Error: " . $mail->ErrorInfo);
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
