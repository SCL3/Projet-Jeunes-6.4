<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {
        die("Vous devez être connecté pour envoyer un e-mail au référent");
    }

    // Vérifier si toutes les données ont été envoyées
    if (isset($_POST["message"])) {
        // Récupérer l'adresse e-mail du référent (vous devez remplacer 'EMAIL_REFERENT' par l'adresse e-mail réelle du référent)
        $emailReferent = "EMAIL_REFERENT";

        // Générer un token unique pour le lien
        $token = uniqid();

        // Enregistrer le token dans la session de l'utilisateur
        $_SESSION['token_referent'] = $token;

        // Générer le lien avec le token
        $lien = "https://example.com/valider_reference.php?token=" . $token;

        // Envoyer l'e-mail au référent
        $sujet = "Demande de référence d'un utilisateur";
        $message = "Vous avez reçu une demande de référence d'un utilisateur. Voici le message associé :\n\n";
        $message .= $_POST["message"] . "\n\n";
        $message .= "Veuillez valider ou rejeter la demande en utilisant le lien suivant :\n";
        $message .= $lien;

        $headers = "From: VotreNom <votre adresse@mail.com>";
        $headers .= "Reply-To: VotreNom votreadresse@mail.com\r\n";
        
            if (mail($emailReferent, $sujet, $message, $headers)) {
               echo "E-mail envoyé avec succès";
              } else {
                  echo "Erreur lors de l'envoi de l'e-mail";
                  }
          } else {
            echo "Veuillez fournir un message";
            }

            } else {
              echo "Méthode non autorisée";
              }
?>
        
        
        
        
        
