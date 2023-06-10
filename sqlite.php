<?php
if ($validation === 0) {
    echo "Erreur de validation";
} else {
    // Connexion à la base de données SQLite
    $db = new SQLite3('user.sqlite');

    // Échapper les valeurs pour éviter les injections SQL
    $prenom = SQLite3::escapeString($prenom);
    $nom = SQLite3::escapeString($nom);
    $email = SQLite3::escapeString($email);
    $date = SQLite3::escapeString($date);

    // Vérifier si l'ancien mot de passe correspond au mot de passe dans la base de données
    $stmt = $db->prepare("SELECT mot_de_passe FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
    $stmt->bindValue(':id_utilisateur', $id_utilisateur, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $ancienMotDePasse = $row['mot_de_passe'];

    if (password_verify($mdpold, $ancienMotDePasse)) {
        // Le mot de passe précédent est correct, nous pouvons mettre à jour les informations

        // Construire et exécuter la requête SQL pour mettre à jour les informations du profil
        $stmt = $db->prepare("UPDATE utilisateur SET prenom = :prenom, nom = :nom, email = :email, date = :date WHERE id_utilisateur = :id_utilisateur");
        $stmt->bindValue(':prenom', $prenom, SQLITE3_TEXT);
        $stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':date', $date, SQLITE3_TEXT);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            echo "Modifications enregistrées avec succès";
        } else {
            echo "Erreur lors de l'enregistrement des modifications : " . $db->lastErrorMsg();
        }
    } else {
        echo "Ancien mot de passe incorrect";
    }

    // Fermer la connexion à la base de données SQLite
    $db->close();
}
?>
