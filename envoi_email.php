<?php

// On utilise PHPMailer pour envoyer des mails avec un serveur local
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fonction pour générer un token aléatoire
function generateToken($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}


// Ancienne version du token aléatoire et envoie de mail qui pourrait nous servir pour la suite 
/* Générer un token aléatoire
$token = generateToken();*/

// Créer le message de confirmation avec le lien contenant le token
/*$message = "Cher $prenom $nom,<br><br>";
$message .= "Merci de vous être inscrit sur notre site.<br>";
$message .= "Veuillez cliquer sur le lien ci-dessous pour confirmer votre adresse e-mail :<br>";
$message .= "<a href='http://www.example.com/confirmation.php?email=$email&token=$token'>Confirmer mon adresse e-mail</a><br><br>";
$message .= "Ce lien expirera dans 24 heures.<br><br>";
$message .= "Cordialement,<br>L'équipe du site";

// Paramètres de l'e-mail
//$to = $email;
$subject = 'Confirmation de votre adresse e-mail';
$headers = "From: jeune@gmail.com\r\n";
$headers .= "Reply-To: yourmail@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Envoyer l'e-mail
/*$mailSent = mail($to, $subject, $message, $headers);*/
/*
if ($mailSent) {
    echo 'Un e-mail de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.';
} else {
    echo 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail de confirmation.';
}*/

function confirmation_jeune($prenom, $nom, $adresse){
    $mail = new PHPMailer;  // Création de l'objet PHPMailer

    $mail -> isSMTP();  // Utilisation de SMTP (Simple Mail Transfer Protocol)
    $mail -> Host = 'smtp.gmail.com';
    $mail -> SMTPAuth = true;
    $mail -> Username = 'no.reply.projetjeunes6.4@gmail.com';
    $mail -> Password = 'lrhifflfvntqpqgw';  // Mot de passe généré par le compte Google
    $mail -> SMTPSecure = 'tls';  // cryptage tls
    $mail -> Port = 587;  // Port en fonction du SMTPSecure
    $mail -> CharSet = "UTF-8";  // Indique l'UTF-8 pour éviter les erreurs d'encodage
    $mail-> Encoding = 'base64';  // 64bit au lieu de 8bit

    // Configuration des adresses e-mail
    $mail->setFrom('no.reply.projetjeunes6.4@gmail.com', "Projet Jeunes 6.4");
    $mail->addAddress($adresse);

    // Configuration du contenu de l'e-mail
    $mail->Subject = "Création d'un compte jeune";
    $mail->Body = "Bienvenue $prenom $nom !\r\n\r\nVous pouvez vous connecter pour faire une demande de référencement.\r\nUne fois votre demande validé par le référent, vous pourrez envoyé vos références validés à un consultant.\r\n\r\nMerci de nous faire confiance ! ";

    // Envoi de l'e-mail
    if ($mail->send()) {  // Vérification si l'email s'est bien envoyé
        echo 'Un email de confimation vous a été envoyé.';
    } 
    else {
        echo "Erreur lors de l'envoi du mail de confimation <br>" . $mail->ErrorInfo;
    }
}

?>
