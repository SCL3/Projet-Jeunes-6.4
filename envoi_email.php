<?php

// Fonction pour générer un token aléatoire
function generateToken($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}

// Récupérer les données du formulaire
$email = $_POST['email'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date = $_POST['date'];
$password = $_POST['password'];

// Générer un token aléatoire
$token = generateToken();

// Créer le message de confirmation avec le lien contenant le token
$message = "Cher $prenom $nom,<br><br>";
$message .= "Merci de vous être inscrit sur notre site.<br>";
$message .= "Veuillez cliquer sur le lien ci-dessous pour confirmer votre adresse e-mail :<br>";
$message .= "<a href='http://www.example.com/confirmation.php?email=$email&token=$token'>Confirmer mon adresse e-mail</a><br><br>";
$message .= "Ce lien expirera dans 24 heures.<br><br>";
$message .= "Cordialement,<br>L'équipe du site";

// Paramètres de l'e-mail
$to = $email;
$subject = 'Confirmation de votre adresse e-mail';
$headers = "From: jeune@gmail.com\r\n";
$headers .= "Reply-To: yourmail@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Envoyer l'e-mail
$mailSent = mail($to, $subject, $message, $headers);

if ($mailSent) {
    echo 'Un e-mail de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.';
} else {
    echo 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail de confirmation.';
}
?>
