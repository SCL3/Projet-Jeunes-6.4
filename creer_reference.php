<?php
session_start();
// Vérifier si l'utilisateur est connecté avant de créer les références
if (isset($_SESSION['email'])) {
  // Fonction pour générer un nom aléatoire
  function generateRandomName($genre) {
    $nomsHomme = array("Dubois", "Martin", "pointcarré", "Thomas", "Chanthrabouth", "abdelkrim", "Richard", "Durand", "Leroy", "Di fiore", "Delpeche", "Laurent", "Lefebvre", "zheng", "Garcia");
    $prenomsHomme = array("Jean", "Philippe", "Pierre", "Nicolas", "David", "Olivier", "François", "Mario", "Mathieu", "Sylvain", "Thierry", "Vincent", "William", "Alexandre", "Christophe");
    $nomsFemme = array("Dubois", "Martin", "Khaldi", "Thomas", "Petit", "abdellatiff", "Lelaurec", "Durand", "Leroy", "Moreau", "Simon", "khatib", "Lefebvre", "Michel", "Garcia");
    $prenomsFemme = array("Sophie", "Isabelle", "Marie", "Catherine", "Sandrine", "Émilie", "Christine", "Valérie", "Caroline", "Julie", "Nathalie", "Virginie", "Anne", "Stéphanie", "Aurélie");

    if ($genre === "homme") {
      $nom = $nomsHomme[array_rand($nomsHomme)];
      $prenom = $prenomsHomme[array_rand($prenomsHomme)];
    } else {
      $nom = $nomsFemme[array_rand($nomsFemme)];
      $prenom = $prenomsFemme[array_rand($prenomsFemme)];
    }
    return array("nom" => $nom, "prenom" => $prenom);
  }

  // Générer une liste de référents aléatoires
  $nombreReferents = 10; // Nombre de référents à créer
  $referents = array();
  for ($i = 0; $i < $nombreReferents; $i++) {
    $genre = ($i % 2 === 0) ? "homme" : "femme";
    $referent = generateRandomName($genre);
    // Vérifier que le référent n'existe pas déjà
    while (in_array($referent, $referents)) {
      $referent = generateRandomName($genre);
    }
    $referent["email"] = strtolower($referent["prenom"] . "." . $referent["nom"] . "@exemple.com"); // Générer un email basé sur le nom et prénom
    $referents[] = $referent;
  }

  // Afficher les référents générés
  foreach ($referents as $referent) {
    echo "Nom : " . $referent["nom"] . "<br>";
    echo "Prénom : " . $referent["prenom"] . "<br>";
    echo "Email : " . $referent["email"] . "<br><br>";

   // Insérer les référents dans la base de données
foreach ($referents as $referent) {
  $nom = $referent["nom"];
  $prenom = $referent["prenom"];
  $email = $referent["email"];

  // Connexion à la base de données SQLite
  $bd = new PDO('sqlite:users.sqlite');  // Remplacez le nom de la base de données par le vôtre

  // Vérifier si le référent existe déjà dans la base de données
  $query = $bd->prepare("SELECT COUNT(*) FROM referents WHERE email = :email");
  $query->bindParam(':email', $email);
  $query->execute();
  $result = $query->fetchColumn();

  if ($result == 0) {  // Si le référent n'existe pas, l'insérer dans la base de données
    $query = $bd->prepare("INSERT INTO referents (nom, prenom, email) VALUES (:nom, :prenom, :email)");
    $query->bindParam(':nom', $nom);
    $query->bindParam(':prenom', $prenom);
    $query->bindParam(':email', $email);
    $query->execute();
  }

  // Fermer la connexion à la base de données
  $bd = null;

  // Afficher les informations du référent généré
  echo "Nom : " . $nom . "<br>";
  echo "Prénom : " . $prenom . "<br>";
  echo "Email : " . $email . "<br><br>";
}

  }
} else {
  // Rediriger l'utilisateur vers la page de connexion si non connecté
  header("Location: login.php");
  exit();
}
?>
