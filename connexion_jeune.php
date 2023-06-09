<?php
include 'envoi_email.php'; // Inclure le fichier d'envoi d'e-mail

session_start();  // On démarre la session de l'utilisateur, pour savoir s'il est connecté sur d'autre page
$_SESSION["connecte"] = false;

function checkUserExistence(string $email) {
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

function test(string $email, string $mdp){
    // Fonction qui vérifie toute les données en fonction de chaques conditions
  
    // Vérifie que chaque valeur ne sont pas vide
    if($email == ""){
        echo "Veuillez inscrire un email";
        return 0;
    }

    if($mdp == ""){
        echo "Veuillez inscrire un mot de passe";
        return 0;
    }
    return 1;
}

function verifierIdentifiant(string $email, string $mdp) {
    $bd = new PDO('sqlite:users.sqlite');
    $requete = $bd->prepare('SELECT COUNT(*) AS count FROM users WHERE email = :email AND mdp = :mdp');
    $requete->bindParam(':email', $email);
    $requete->bindParam(':mdp', $mdp);
    $requete->execute();
    
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    $compteur = $resultat['count'];
    
    return $compteur > 0;  // Si compteur > 0 la fonction renvoie true, car l'identifiant + mdp existe.
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($go == 0){  // Si l'utilisateur a essayé de se connecter une fois (cette condition est toujours effectué)
        $_SESSION['attente'] = time();  
        $temps_ecoule = 10 - ($_SESSION['attente'] - $_SESSION['temps']);
        if($temps_ecoule <= 0){
            $go = 1;
        }
        else{
            echo "veuillez attendre $temps_ecoule secondes";
        }
    
    }
    if (isset($_POST["email"], $_POST["mdp"]) && $go == 1){
        // Récupérer les données du formulaire de connexion
        $email = $_POST["email"]; 
        $mdp = $_POST["mdp"];
        
        // Connexion à la base de données SQLite
        $bd = new PDO('sqlite:users.sqlite');  // base de données sqlite3
        // Création de la table si elle n'existe pas déjà
        $bd->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, prenom TEXT, nom TEXT, email TEXT, date_naissance TEXT, mdp TEXT)');

        if(test($email, $mdp) == 1){
            if(verifierIdentifiant($email, $mdp)){
                $_SESSION["connecte"] = true;
                echo '<meta http-equiv="refresh" content="0;url=jeune_compte.php">';  //redirige vers une autre page
                exit;
            }
            else{
                echo "L'identifiant ou le mot de passe est incorrect";
                $_SESSION['temps'] = time();  // On va faire patienter la personne quelque seconde avant un nouvel essaie (Le dissuader de craquer un mot de passe de manière force)
                $go = 0;
            }
        }



        /*
        // Vérifier si l'utilisateur existe
        if (checkUserExistence($email)) {
            // L'utilisateur existe, effectuer les autres vérifications (mot de passe, etc.)
            // ...
        
                // Autres actions à effectuer pour la connexion réussie
            echo "Connexion réussie";
        }
        else {
        // L'utilisateur n'existe pas, afficher un message d'erreur
        echo "<br>L'utilisateur n'existe pas. Veuillez vérifier vos informations de connexion.";
        }*/
    }  
}
?>


