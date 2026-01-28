<?php
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include __DIR__ . '/includes/head-ar.php';
include __DIR__ . '/includes/header-ar.php';

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'petrichoorteam.ae@gmail.com';
        $mail->Password   = 'efch nfvi muso ddno';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('b2b@petrichoorchocolate.com');
        $mail->Subject = $subject ?: 'رسالة من نموذج التواصل';
        $mail->Body    = "الاسم: $name\nالبريد الإلكتروني: $email\nالموضوع: $subject\nالرسالة:\n$message";

        $mail->send();
        $successMessage = "تم إرسال رسالتك بنجاح!";
    } catch (Exception $e) {
        $errorMessage = "تعذر إرسال الرسالة. خطأ البريد: {$mail->ErrorInfo}";
    }
}
?>

<div class="container mt-5 contact-page" dir="rtl">
    <div class="text-center py-5">
        <h1>تواصل معنا</h1>
        <p class="lead">يسعدنا سماع آرائكم واستفساراتكم! لا تترددوا في التواصل معنا.</p>
    </div>

    <div class="row mb-5">
        <div class="col-md-4">
            <h3>تفاصيل الاتصال</h3>
            <p><strong>البريد الإلكتروني:</strong> <a href="mailto:b2b@petrichoorchocolate.com">b2b@petrichoorchocolate.com</a></p>
            <p><strong>الهاتف:</strong> <a href="tel:+971522257993">+971 52 225 7993</a></p>
            <p><strong>إنستغرام:</strong> <a href="https://www.instagram.com/petrichoor.ae/" target="_blank">@petrichoor.ae</a></p>
            <p><strong>الموقع:</strong> عجمان، الإمارات العربية المتحدة</p>
        </div>

        <div class="col-md-8 mb-4">
            <h3>موقعنا</h3>
            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4434.662265842468!2d55.498473476058976!3d25.40337172331767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ef5f761ce2d0089%3A0x203c2ef6688df0d8!2sPetrichoor%20Chocolate!5e1!3m2!1sar!2sae!4v1759142552905!5m2!1sar!2sae"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <h3>أرسل لنا رسالة</h3>

            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?= $successMessage ?></div>
            <?php endif; ?>
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" id="name" required placeholder="أدخل اسمك الكامل">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" id="email" required placeholder="أدخل بريدك الإلكتروني">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">الموضوع</label>
                    <input type="text" name="subject" class="form-control" id="subject" required placeholder="أدخل الموضوع">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">الرسالة</label>
                    <textarea name="message" class="form-control" id="message" rows="5" required placeholder="اكتب رسالتك هنا"></textarea>
                </div>
                <button type="submit" class="btn btn-beige btn-submit">إرسال الرسالة</button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer-ar.php'; ?>
