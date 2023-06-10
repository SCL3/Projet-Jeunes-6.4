<?php
include 'fonction.php';  // Include le fichier avec toute les fonctions pour la vérification des identifiants.
echo "test";
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Si la requête est bien reçu
    // Vérifier si toutes les données a été envoyé
    if (isset($_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["date"], $_POST["mdpold"], $_POST["mdp1"], $_POST["mdp2"])){
        // Récupération de toutes les données
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $date = $_POST["date"];
        $mdpold = $_POST["mdpold"];
        $mdp1 = $_POST["mdp1"];
        $mdp2 = $_POST["mdp2"];
        echo "test";
    }
}
?>

