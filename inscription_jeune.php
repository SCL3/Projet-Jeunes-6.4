<?php
include 'envoi_email.php'; // Inclure le fichier d'envoi d'e-mail


// Fonction pour calculer l'âge à partir de la date de naissance
function calculerAge($date) {
  $naissance = new DateTime($date); 
  $ajd = new DateTime();  // La date d'aujourd'hui
  $age = $ajd->diff($naissance)->y;
  echo $age;
  return $age;
}

function test(string $prenom, string $nom, string $email, string $date, string $mdp1, string $mdp2){
  // Fonction qui vérifie toute les données en fonction de chaques conditions
  
  // Vérifie que chaque valeur ne sont pas vide
 if ($prenom === "") {
    echo "Veuillez inscrire votre prénom";
    return 0;
  }

  if ($nom === "") {
    echo "Veuillez inscrire votre nom";
    return 0;
  }
  if (!preg_match("/^[a-zA-Z-' ]*$/",$prenom)) {  // Vérifie que le prénom est bien composé de lettre seulement
    echo "Le prénom doit seulement être composé de lettre !";
    return 0;
  }

 
  if (!preg_match("/^[a-zA-Z-' ]*$/",$nom)) {
    echo "Le nom de famille doit seulement être composé de lettre !";
    return 0;
  }

  if($email === ""){
    echo "Veuillez inscrire un email";
    return 0;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Vérifie que l'email est au bon format
    echo "Le format d'email n'est pas valide";
    return 0;
  }

  if($date === ""){
    echo "Veuillez inscrire une date de naissance";
    return 0;
  }

  // Sécurité du mot de passe 
  if($mdp1 === ""){
    echo "Veuillez inscrire un mot de passe";
    return 0;
  }
  if($mdp2 === ""){
    echo "Veuillez vérifier votre mot de passe";
    return 0;
  }
  
   if ($mdp1 === "" || $mdp2 === "") {
    echo "Veuillez inscrire votre mot de passe";
    return 0;
  }

  if ($mdp1 !== $mdp2) {
    echo "Les mots de passe ne correspondent pas";
    return 0;
  }

  if(strlen($mdp1) <= 7){
    echo "Pour plus de sécurité, <br> le mot de passe doit contenir au moins 8 caractères";
    return 0;
  }
  if (!preg_match("/\d/", $mdp1)) {
    echo "Pour plus de sécurité, <br> le mot de passe doit contenir au moins 1 chiffre";
    return 0;
  }
  if (!preg_match("/[A-Z]/", $mdp1)) {
    echo "Pour plus de sécurité, <br> le mot de passe doit contenir au moins 1 lettre majuscule";
    return 0;
  }
  if (!preg_match("/[a-z]/", $mdp1)) {
    echo "Pour plus de sécurité, <br> le mot de passe doit contenir au moins 1 lettre minuscule";
    return 0;
  }
  if (!preg_match("/\W/", $mdp1)) {
    echo "Pour plus de sécurité, <br> le mot de passe doit contenir au moins 1 caractère spécial";
    return 0;
  } 
  

  // Vérification de l'âge entre 14 et 30 ans
  $age = calculerAge($date); // Appel d'une fonction pour calculer l'âge à partir de la date de naissance
  if ($age < 14) {
    echo "Vous êtes trop jeune pour vous inscrire $age.";
    return 0;
  }
  if ($age > 30){
    echo "Vous êtes trop vieux pour vous inscrire $age.";
    return 0;
  }

  /*// On vérifie l'âge (ENTRE 16 et 30)
  $temp = strtotime($date);
  $annee = date('Y',$temp);
  if ($annee < 1993){ // Ici, le "jeune" a plus de 30 ans...
    echo "Tu es peut-être un peu trop vieux pour être 'jeune'...";
    return 0;
  } 
  if($annee >= date('Y')){  // Compare sa date de naissance avec l'année actuelle
    echo "Tu viens du futur ?? :O";
    return 0;
  }*/
  
  return 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Si la requête est bien reçu
  // Vérifier si toutes les données a été envoyé
  if (isset($_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["date"], $_POST["mdp1"], $_POST["mdp2"])){
    // Récupération de toutes les données
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $date = $_POST["date"];
    $mdp1 = $_POST["mdp1"];
    $mdp2 = $_POST["mdp2"];

    // Connexion à la base de données SQLite
    $bd = new PDO('sqlite:users.sqlite');  // base de données sqlite3
    // Création de la table si elle n'existe pas déjà
    $bd->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, prenom TEXT, nom TEXT, email TEXT, date_naissance TEXT, mdp TEXT)');

    
  /*   $validation = test($prenom, $nom, $email, $date, $mdp1, $mdp2);

    // Si la validation échoue, vous pouvez effectuer un traitement approprié (par exemple, afficher un message d'erreur)
    if (!empty($validation)) {
      // Traitement en cas d'erreur de validation
      echo $validation;
    } else {
        // Vérification d'un mail unique :
    // Requête SELECT pour vérifier l'existence de l'e-mail
    $query = "SELECT COUNT(*) FROM users WHERE email = :email";
    $statement = $bd->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();
        
    $compteur = $statement->fetchColumn();  // (>0 : l'email existe déjà, =0 : l'email n'existe pas)
    if($compteur > 0){
      echo "Un compte est déjà enregistré avec cet email.";
    }

    if($compteur == 0 && test($prenom, $nom, $email, $date, $mdp1, $mdp2) == 1 ){
      // Insertion des données dans la table
      $bd->exec("INSERT INTO users (prenom, nom, email, date_naissance, mdp) VALUES ('$prenom', '$nom', '$email', '$date', '$mdp1')");
      
      
      echo "Les informations sont valides. Enregistrement dans la base de données...";
      echo "Compte crée !<br>";

      // Envoi du mail de confimation
      confirmation_jeune($prenom, $nom, $email);  
      
     
      // Autres actions à effectuer pour l'inscription réussie
      }
     
    }*/
    
    
    // Vérification d'un mail unique :
    // Requête SELECT pour vérifier l'existence de l'e-mail
    $query = "SELECT COUNT(*) FROM users WHERE email = :email";
    $statement = $bd->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();
        
    $compteur = $statement->fetchColumn();  // (>0 : l'email existe déjà, =0 : l'email n'existe pas)
    if($compteur > 0){
      echo "Un compte est déjà enregistré avec cet email.";
    }

    if($compteur == 0 && test($prenom, $nom, $email, $date, $mdp1, $mdp2) == 1 ){
      // Insertion des données dans la table
      $bd->exec("INSERT INTO users (prenom, nom, email, date_naissance, mdp) VALUES ('$prenom', '$nom', '$email', '$date', '$mdp1')");
      
      echo "Compte crée !<br>";

      // Envoi du mail de confimation
      confirmation_jeune($prenom, $nom, $email);  
      
     
      // Autres actions à effectuer pour l'inscription réussie
      }
     
  }
}
?>
