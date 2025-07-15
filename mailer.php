<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';



//Carrega o autoloader do Composer (criado pelo composer, não incluído com o PHPMailer)
require 'vendor/autoload.php';

//Cria uma instância; passar `true` ativa exceções
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Ativa saída de depuração detalhada
    $mail->isSMTP();                                            //Envia usando SMTP
    $mail->Host       = 'smtp.mail.unitecpr.com.br';                     //Define o servidor SMTP para envio
    $mail->SMTPAuth   = true;                                   //Ativa autenticação SMTP
    $mail->Username   = 'unitecescola@unitecpr.com.br';                     //Nome de usuário SMTP
    $mail->Password   = 'lmIp@W5%YzwC';                               //Senha SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Ativa criptografia TLS implícita
    $mail->Port       = 465;  


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

    // ------------------------------------------------
    // 5) Endereços e conteúdo
    // ------------------------------------------------
    $mail->setFrom('unitecescola@unitecpr.com.br', 'Equipe Unitec');
    $mail->addAddress('unitecescola@unitecpr.com.br', 'Equipe Unitec');
    $mail->addReplyTo($email, $name);
    $mail->addBCC('saulo.silva@unitecpr.com.br'); // Adicione BCC se necessário
    

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
    echo 'Message has been sent';
    exit('Obrigado! Sua mensagem foi enviada.');

} catch (Exception $e) {
    error_log('Mailer Error: ' . $e->getMessage());
    http_response_code(500);
    exit('Não foi possível enviar a mensagem. Tente novamente mais tarde.');
} finally {
    // Limpa os dados sensíveis da memória
    unset($name, $email, $phone, $subject, $message);
}