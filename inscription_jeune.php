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
    
    if(test($prenom, $nom, $email, $date, $mdp1, $mdp2) == 1){
      echo "création du compte";
    }
    
    
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
}
?>
