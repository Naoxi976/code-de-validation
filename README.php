# code-de-validation
<!DOCTYPE html>
<html lang="fr">
<head>
<body
<form action="send_code.php" method="POST">
  <input type="email" name="email" placeholder="Votre e-mail" required>
  <button type="submit">Envoyer le code</button>
</form>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // via Composer

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $code = rand(100000, 999999); // Code à 6 chiffres

    // Stocke le code temporairement (ex : session, base de données...)
    session_start();
    $_SESSION['validation_code'] = $code;

    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP (exemple avec Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tonemail@gmail.com';
        $mail->Password = 'tonmotdepasseoujeton';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('tonemail@gmail.com', 'Fluxio');
        $mail->addAddress($email);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Votre code de validation';
        $mail->Body = "Voici votre code de validation : <b>$code</b>";

        $mail->send();
        echo 'Code envoyé avec succès !';
    } catch (Exception $e) {
        echo "Erreur : {$mail->ErrorInfo}";
    }
}
?>
</body>
</head>
</html>
