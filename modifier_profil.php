<?php
session_start();
// Vérifier si l'utilisateur est connecté avant d'effectuer la modification du profil
if (isset($_SESSION['email'])) {
  // Traitement du formulaire de modification du profil
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    // Effectuer les modifications dans la base de données (exemple)
    $email = $_SESSION['email'];
    $bd = new PDO('sqlite:users.sqlite');  // base de données SQLite
    $bd->exec("UPDATE users SET prenom='$prenom', nom='$nom' WHERE email='$email'");
    // Rediriger l'utilisateur vers la page d'accueil du compte Jeune
    header("Location: jeune.html");
    exit();
  }
} else {
  // Rediriger l'utilisateur vers la page de connexion si non connecté
  header("Location: jeune.html ");
  exit();
}
?>
