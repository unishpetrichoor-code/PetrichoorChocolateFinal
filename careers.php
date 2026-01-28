<?php

// ------------------- Includes -------------------
include __DIR__ . '/includes/db_connect.php';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';

// ------------------- PHPMailer Setup -------------------
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ------------------- Fetch Jobs from Database -------------------
$jobsResult = $mysqli->query("SELECT * FROM jobs ORDER BY created_at DESC");

$jobs = [];
if ($jobsResult && $jobsResult->num_rows > 0) {
    while ($row = $jobsResult->fetch_assoc()) {
        $jobs[] = $row;
    }
}

// ------------------- Handle Job Application -------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_application'])) {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $position = $_POST['position'] ?? '';
    $resume = $_FILES['resume'];

    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $resumePath = $uploadDir . basename($resume['name']);

    if (move_uploaded_file($resume['tmp_name'], $resumePath)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'petrichoorteam.ae@gmail.com';
            $mail->Password   = 'efch nfvi muso ddno'; // Use Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress('b2b@petrichoorchocolate.com');
            $mail->Subject = "New Job Application: $position";
            $mail->Body    = "Name: $name\nEmail: $email\nPosition: $position";

            $mail->addAttachment($resumePath);
            $mail->send();

            if (file_exists($resumePath)) unlink($resumePath);
            $_SESSION['successMessage'] = "Your application has been submitted successfully!";
        } catch (Exception $e) {
            if (file_exists($resumePath)) unlink($resumePath);
            $_SESSION['errorMessage'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['errorMessage'] = "There was an error uploading your resume. Please try again.";
    }

    header("Location: careers.php");
    exit;
}

// ------------------- Flash Messages -------------------
$successMessage = $_SESSION['successMessage'] ?? '';
$errorMessage = $_SESSION['errorMessage'] ?? '';
unset($_SESSION['successMessage'], $_SESSION['errorMessage']);
?>

<div class="container mt-5">
    <div class="text-center py-5">
        <h1>Careers at Petrichoor Chocolate</h1>
        <p class="lead">Join our passionate team and craft the finest chocolates in the UAE.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Current Openings</h2>
            <div class="accordion mb-5" id="jobOpenings">
                <?php if(!empty($jobs)): ?>
                    <?php foreach ($jobs as $index => $job): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#job<?= $index ?>">
                                    <?= htmlspecialchars($job['title']) ?>
                                </button>
                            </h2>
                            <div id="job<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#jobOpenings">
                                <div class="accordion-body">
                                    <?= nl2br(htmlspecialchars($job['description'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No job openings available at the moment.</p>
                <?php endif; ?>
            </div>

            <h3>Apply Now</h3>

            <?php if ($successMessage): ?>
                <p class="text-success"><?= $successMessage ?></p>
            <?php endif; ?>
            <?php if ($errorMessage): ?>
                <p class="text-danger"><?= $errorMessage ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <select name="position" class="form-control" required>
                        <option value="">Select Position</option>
                        <?php foreach ($jobs as $job): ?>
                            <option><?= htmlspecialchars($job['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="resume" class="form-label">Upload Resume (PDF/DOC)</label>
                    <input type="file" name="resume" class="form-control" id="resume" required>
                </div>
                <button type="submit" name="submit_application" class="btn btn-beige btn-submit">Submit Application</button>
            </form>
        </div>
    </div>
</div>

<style>
/* Submit Button Hover */
.btn-submit {
    transition: all 0.3s ease;
}
.btn-submit:hover {
    background-color: #013220 !important; /* Dark Green hover */
    color: #fff !important;
    transform: scale(1.05);
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
