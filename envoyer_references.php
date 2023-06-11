<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit;
}

// Vérifier si des références ont été sélectionnées
if (isset($_POST['references'])) {
    $references = $_POST['references'];

    // Traitement pour l'envoi des références sélectionnées à un consultant
    $consultantEmail = "consultant@example.com"; // Adresse e-mail du consultant

    $selectedReferences = implode(', ', $references); // Convertir les références en une chaîne de caractères

    $subject = "Références sélectionnées";
    $message = "Voici les références sélectionnées :\n\n$selectedReferences";
    $headers = array(
        'From' => 'webmaster@example.com',
        'Reply-To' => 'webmaster@example.com',
        'X-Mailer' => 'PHP/' . phpversion()
    );
    mail($consultantEmail, $subject, $message, $headers);

    echo "Les références sélectionnées ($selectedReferences) ont été envoyées au consultant avec succès.";
} else {
    echo "Aucune référence sélectionnée.";
}
?>
