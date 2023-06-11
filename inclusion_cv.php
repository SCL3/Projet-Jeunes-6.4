<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: jeune.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit;
}

// Vérifier si des références ont été sélectionnées
if (isset($_POST['references'])) {
    $references = $_POST['references'];

    // Traitement pour l'inclusion des références sélectionnées dans le CV
    $cvReferences = implode(', ', $references); // Convertir les références en une chaîne de caractères

    //Mettre à jour la base de données avec les références sélectionnées
    $cvId = $_SESSION['cvId']; // Supposons que l'ID du CV de l'utilisateur est stocké dans la session

    // Connexion à la base de données et mise à jour du champ des références du CV
    $db = new PDO('mysql:host=localhost;dbname=users.db', 'nom_utilisateur', 'mot_de_passe');
    $query = "UPDATE cv SET references = :cvReferences WHERE id = :cvId";
    $statement = $db->prepare($query);
    $statement->bindParam(':cvReferences', $cvReferences);
    $statement->bindParam(':cvId', $cvId);
    $statement->execute();

    echo "Les références sélectionnées ($cvReferences) ont été incluses dans le CV avec succès.";
} else {
    echo "Aucune référence sélectionnée.";
}
?>
