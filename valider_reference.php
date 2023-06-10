
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Vérifier si le token est présent dans l'URL
    if (isset($_GET["token"])) {
        // Vérifier si le token correspond à celui enregistré dans la session de l'utilisateur
        if ($_GET["token"] === $_SESSION['token_referent']) {
            // Le token est valide, vous pouvez effectuer les actions nécessaires ici
            // Par exemple, marquer la demande de référence comme validée dans votre base de données

            echo "Demande de référence validée";
        } else {
            echo "Token invalide";
        }
    } else {
        echo "Token manquant";
    }
} else {
    echo "Méthode non autorisée";
}
?>
