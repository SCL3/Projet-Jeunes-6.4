<?php

// Fonction pour calculer l'âge à partir de la date de naissance
function calculerAge($date) {
  $naissance = new DateTime($date); 
  $ajd = new DateTime();  // La date d'aujourd'hui
  $age = $ajd->diff($naissance)->y;
  return $age;
}

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

  // Sécurité du mot de passe 
  if($mdp1 == ""){
    echo "Veuillez inscrire un mot de passe";
    return 0;
  }
  if($mdp2 == ""){
    echo "Veuillez vérifier votre mot de passe";
    return 0;
  }
  if($mdp1 != $mdp2){
    echo "Le mot de passe de vérification est différent"; 
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

?>