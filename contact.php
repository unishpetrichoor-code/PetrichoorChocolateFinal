<?php
// ------------------- PHPMailer Setup -------------------
// Include PHPMailer classes before any executable code
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ------------------- Includes -------------------
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';

// ------------------- Messages -------------------
$successMessage = '';
$errorMessage = '';

// ------------------- Handle Form Submission -------------------
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
        $mail->Username   = 'petrichoorteam.ae@gmail.com'; // Your Gmail
        $mail->Password   = 'efch nfvi muso ddno'; // Gmail App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('b2b@petrichoorchocolate.com'); // Your business email
        $mail->Subject = $subject ?: 'Contact Form Submission';
        $mail->Body    = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

        $mail->send();
        $successMessage = "Your message has been sent successfully!";
    } catch (Exception $e) {
        $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<div class="container mt-5">
    <div class="text-center py-5">
        <h1>Contact Us</h1>
        <p class="lead">We would love to hear from you! Reach out with any queries or feedback.</p>
    </div>

    <div class="row mb-5">
        <!-- Contact Details -->
        <div class="col-md-4">
            <h3>Our Details</h3>
            <p><strong>Email:</strong> <a href="mailto:b2b@petrichoorchocolate.com">b2b@petrichoorchocolate.com</a></p>
            <p><strong>Phone:</strong> <a href="tel:+971123456789">+971 58 679 9389</a></p>
            <p><strong>Instagram:</strong> <a href="https://www.instagram.com/petrichoor.ae/" target="_blank">@petrichoor.ae</a></p>
            <p><strong>Location:</strong> Ajman, UAE</p>
        </div>

        <!-- Google Map -->
        <div class="col-md-8 mb-4">
            <h3>Our Location</h3>
            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4434.662265842468!2d55.498473476058976!3d25.40337172331767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ef5f761ce2d0089%3A0x203c2ef6688df0d8!2sPetrichoor%20Chocolate!5e1!3m2!1sen!2sae!4v1759142552905!5m2!1sen!2sae"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <h3>Send Us a Message</h3>

            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?= $successMessage ?></div>
            <?php endif; ?>
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" id="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" class="form-control" id="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-beige btn-submit">Send Message</button>
            </form>
        </div>
    </div>
</div>

<style>
/* Sticky Footer */
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
main {
    flex: 1;
}
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
