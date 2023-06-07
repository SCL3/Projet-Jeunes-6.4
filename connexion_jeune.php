<?php
	echo "Les messages d'erreurs seront ici !";


include 'envoi_email.php'; // Inclure le fichier d'envoi d'e-mail

function checkUserExistence($email) {
    // Connexion à la base de données SQLite
    $db = new PDO('sqlite:users.sqlite');
    
    // Vérifier si l'utilisateur existe dans la base de données
    $query = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();
    
    $count = $query->fetchColumn();
    
    if ($count > 0) {
        return true; // L'utilisateur existe
    } else {
        return false; // L'utilisateur n'existe pas
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire de connexion
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Vérifier si l'utilisateur existe
    if (checkUserExistence($email)) {
        // L'utilisateur existe, effectuer les autres vérifications (mot de passe, etc.)
        // ...
        
        // Autres actions à effectuer pour la connexion réussie
        echo "Connexion réussie";
    } else {
        // L'utilisateur n'existe pas, afficher un message d'erreur
        echo "L'utilisateur n'existe pas. Veuillez vérifier vos informations de connexion.";
    }
}
?>


