<?php

function test(string $prenom, string $nom, string $email, string $date, string $mdp1, string $mdp2){
  // Fonction qui vérifie toute les données en fonction de chaques conditions
  
  // Vérifie que chaque valeur ne sont pas vide
  if($prenom == ""){
    echo "Veuillez inscrire votre prénom";
    return 0;  // Les tests ne sont pas valide, on renvoie 0 (Faux)
  }
  if (!preg_match("/^[a-zA-Z-' ]*$/",$prenom)) {  // Vérifie que le prénom est bien composé de lettre seulement
    echo "Le prénom doit seulement être composé de lettre !";
    return 0;
  }

  if($nom == ""){
    echo "Veuillez inscrire votre nom de famille";
    return 0;
  }
  if (!preg_match("/^[a-zA-Z-' ]*$/",$nom)) {
    echo "Le nom de famille doit seulement être composé de lettre !";
    return 0;
  }

  if($email == ""){
    echo "Veuillez inscrire un email";
    return 0;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Vérifie que l'email est au bon format
    echo "Le format d'email n'est pas valide";
    return 0;
  }

  if($date == ""){
    echo "Veuillez inscrire une date de naissance";
    return 0;
  }

  if($mdp1 == ""){
    echo "Veuillez inscrire un mot de passe";
    return 0;
  }
  if($mdp2 == ""){
    echo "Veuillez vérifier votre mot de passe";
    return 0;
  }
  if($mdp1 != $mdp2){
    echo "Le mot de passe de vérification est différent";  //echo "Le mot de passe doit contenir plus de 8 caractères"
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

  // On vérifie l'âge (ENTRE 16 et 30)
  $temp = strtotime($date);
  $annee = date('Y',$temp);
  if ($annee < 1993){ // Ici, le "jeune" a plus de 30 ans...
    echo "Tu es peut-être un peu trop vieux pour être 'jeune'...";
    return 0;
  } 
  if($annee >= date('Y')){  // Compare sa date de naissance avec l'année actuelle
    echo "Tu viens du futur ?? :O";
    return 0;
  }
  
  return 1;
}

require_once 'envoi_email.php'; // Inclure le fichier d'envoi d'e-mail


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
    
    $age = calculateAge($date); // Appel d'une fonction pour calculer l'âge à partir de la date de naissance
    
    if ($age >= 14 && $age <= 30) { // Vérification de l'âge entre 14 et 30 ans
      if(test($prenom, $nom, $email, $date, $mdp1, $mdp2) == 1){
        // Connexion à la base de données SQLite
        $database = new PDO('sqlite:users.db');
        // Création de la table si elle n'existe pas déjà
        $database->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, prenom TEXT, nom TEXT, email TEXT, date_naissance TEXT, mdp TEXT)');
        // Insertion des données dans la table
        $database->exec("INSERT INTO users (prenom, nom, email, date_naissance, mdp) VALUES ('$prenom', '$nom', '$email', '$date', '$mdp1')");
       
        // Envoi du mail de confirmation
        
        require_once 'envoi_email.php'; // Inclure le fichier d'envoi d'e-mail
        
        $subject = "Confirmation d'inscription";
        $message = "Bonjour $prenom,\n\nMerci de vous être inscrit sur notre site.\n\nVeuillez cliquer sur le lien suivant pour confirmer votre adresse e-mail : [lien de confirmation].\n\nCordialement,\nL'équipe du site";
        $headers = "From: no-reply@monsite.com";
        // mail($email, $subject, $message, $headers);
        
        echo "Création du compte. Un email de confirmation a été envoyé à votre adresse.";
        // Autres actions à effectuer pour l'inscription réussie
      }
    } elseif ($age < 14) {
      echo "Vous êtes trop jeune pour vous inscrire.";
    } else {
      echo "Vous êtes trop vieux pour vous inscrire.";
    }
  }
}

// Fonction pour calculer l'âge à partir de la date de naissance
function calculateAge($date) {
  $birthDate = new DateTime($date);
  $today = new DateTime();
  $age = $today->diff($birthDate)->y;
  return $age;
}

  

 
 
  /*if (isset($_POST["prenom"])) {
    $prenom = $_POST["prenom"];
  }
  else{
    echo "Veuillez inscrire votre prénom.";
  }
  else if (isset($_POST["nom"])) {
    $nom = $_POST["nom"];
    echo "Nom : " . $nom . "<br>";
  }
  else if (isset($_POST["email"])) {
    $email = $_POST["email"];
    echo "Email : " . $email ."<br>";
  }
  if (isset($_POST["date"])) {
     $email = $_POST["email"];
    echo "Date : " . $date ."<br>";
  }
  if (isset($_POST["mdp1"])) {
    $email = $_POST["email"];
    echo "Mdp1 : " . $mdp1 ."<br>";
  }
  if (isset($_POST["mdp2"])) {
    $mdp2 = $_POST["mdp2"];
    echo "Mdp2 : " . $mdp2 ."<br>";
  }*/

?>
