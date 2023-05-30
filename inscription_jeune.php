<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Vérifier si le prénom a été envoyé
  if (isset($_POST["prenom"])) {
    $prenom = $_POST["prenom"];
    
    // Faire quelque chose avec le prénom
    // Par exemple, l'afficher
    echo "Prénom : " . $prenom ."<br>";
  }
  if (isset($_POST["nom"])) {
    $nom = $_POST["nom"];
    
    // Faire quelque chose avec le prénom
    // Par exemple, l'afficher
    echo "Nom : " . $nom;
  }
}
?>
