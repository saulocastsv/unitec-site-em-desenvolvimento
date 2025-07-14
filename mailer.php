<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ----------------------------------------------------
// 1) Bloqueia requisições inválidas
// ----------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

// ----------------------------------------------------
// 2) Honeypot anti-spam
// ----------------------------------------------------
if (!empty($_POST['website'])) {
    http_response_code(400);
    exit('Ação suspeita detectada.');
}

// ----------------------------------------------------
// 3) Sanitização e validação
// ----------------------------------------------------
$name    = trim($_POST['name']     ?? '');
$email   = trim($_POST['email']    ?? '');
$phone   = trim($_POST['phone']    ?? '');
$subject = trim($_POST['subject']  ?? 'Sem assunto');
$message = trim($_POST['message']  ?? '');

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Preencha todos os campos obrigatórios.');
}

// ----------------------------------------------------
// 4) Configura PHPMailer SMTP
// ----------------------------------------------------
$mail          = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST']      ?? 'mail.unitecpr.com.br';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USER']      ?? '_mainaccount@unitecpr.com.br';
    $mail->Password   = $_ENV['SMTP_PASS']      ?? '5Ah5$(25.y[d';
    $mail->Port       = $_ENV['SMTP_PORT']      ?? 465;
    $mail->SMTPSecure = $_ENV['SMTP_SECURE']    ?? PHPMailer::ENCRYPTION_STARTTLS;

    // ------------------------------------------------
    // 5) Endereços e conteúdo
    // ------------------------------------------------
    $mail->setFrom($mail->Username, 'Form Contato');
    $mail->addReplyTo($email, $name);
    $mail->addAddress('contato@seudominio.com', 'Equipe');

    $mail->Subject = "[Site] {$subject} – {$name}";
    $mail->Body    =
        "Nome: {$name}\n" .
        "E-mail: {$email}\n" .
        "Telefone: {$phone}\n\n" .
        "Mensagem:\n{$message}";

    // ------------------------------------------------
    // 6) Envia e responde ao front
    // ------------------------------------------------
    $mail->send();
    http_response_code(200);
    exit('Obrigado! Sua mensagem foi enviada.');

} catch (Exception $e) {
    error_log('Mailer Error: ' . $e->getMessage());
    http_response_code(500);
    exit('Não foi possível enviar a mensagem. Tente novamente mais tarde.');
}
