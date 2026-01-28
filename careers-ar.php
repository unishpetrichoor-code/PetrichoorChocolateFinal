<?php
// ------------------- Includes -------------------
include __DIR__ . '/includes/db_connect.php';
include __DIR__ . '/includes/head-ar.php';
$lang = 'ar'; // set language for header
include __DIR__ . '/includes/header-ar.php';

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
            $mail->Password   = 'efch nfvi muso ddno'; // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress('b2b@petrichoorchocolate.com');
            $mail->Subject = "طلب توظيف جديد: $position";
            $mail->Body    = "الاسم: $name\nالبريد الإلكتروني: $email\nالوظيفة: $position";

            $mail->addAttachment($resumePath);
            $mail->send();

            if (file_exists($resumePath)) unlink($resumePath);
            $_SESSION['successMessage'] = "تم تقديم طلبك بنجاح!";
        } catch (Exception $e) {
            if (file_exists($resumePath)) unlink($resumePath);
            $_SESSION['errorMessage'] = "تعذر إرسال الرسالة. خطأ: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['errorMessage'] = "حدث خطأ أثناء رفع السيرة الذاتية. الرجاء المحاولة مرة أخرى.";
    }

    header("Location: careers_ar.php");
    exit;
}

// ------------------- Flash Messages -------------------
$successMessage = $_SESSION['successMessage'] ?? '';
$errorMessage = $_SESSION['errorMessage'] ?? '';
unset($_SESSION['successMessage'], $_SESSION['errorMessage']);
?>

<div class="container mt-5" dir="rtl" style="text-align: right;">
    <div class="text-center py-5">
        <h1>الوظائف في Petrichoor Chocolate</h1>
        <p class="lead">انضم إلى فريقنا الشغوف وشارك في صناعة أرقى أنواع الشوكولاتة في الإمارات.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>الوظائف المتاحة حالياً</h2>
            <div class="accordion mb-5" id="jobOpenings">
                <?php if(!empty($jobs)): ?>
                    <?php foreach ($jobs as $index => $job): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#job<?= $index ?>">
                                    <?= htmlspecialchars($job['title_ar'] ?? $job['title']) ?>
                                </button>
                            </h2>
                            <div id="job<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#jobOpenings">
                                <div class="accordion-body">
                                    <?= nl2br(htmlspecialchars($job['description_ar'] ?? $job['description'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">لا توجد وظائف شاغرة حالياً.</p>
                <?php endif; ?>
            </div>

            <h3>قدّم الآن</h3>

            <?php if ($successMessage): ?>
                <p class="text-success"><?= $successMessage ?></p>
            <?php endif; ?>
            <?php if ($errorMessage): ?>
                <p class="text-danger"><?= $errorMessage ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">الوظيفة</label>
                    <select name="position" class="form-control" required>
                        <option value="">اختر الوظيفة</option>
                        <?php foreach ($jobs as $job): ?>
                            <option><?= htmlspecialchars($job['title_ar'] ?? $job['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="resume" class="form-label">رفع السيرة الذاتية (PDF/DOC)</label>
                    <input type="file" name="resume" class="form-control" id="resume" required>
                </div>
                <button type="submit" name="submit_application" class="btn btn-beige btn-submit">إرسال الطلب</button>
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
