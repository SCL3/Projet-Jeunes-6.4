<?php
// ...

// Récupérer les référents depuis la base de données ou de toute autre source
$bd = new PDO('sqlite:users.sqlite');  // Remplacez le nom de la base de données par le vôtre

$query = $bd->prepare("SELECT * FROM referents");
$query->execute();
$referents = $query->fetchAll(PDO::FETCH_ASSOC);

// Afficher la liste de référents
foreach ($referents as $referent) {
  $nom = $referent["nom"];
  $prenom = $referent["prenom"];
  $email = $referent["email"];

  echo "Nom : " . $nom . "<br>";
  echo "Prénom : " . $prenom . "<br>";
  echo "Email : " . $email . "<br><br>";
}

// Fermer la connexion à la base de données
$bd = null;

// ...
?>
