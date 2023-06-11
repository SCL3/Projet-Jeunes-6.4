<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {
    header("Location: jeune.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit;
}
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
	<title>Page Jeune</title>
	<link rel="icon" type="image/png" href="Images/icone1.png">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>  // Script pour AJAX et les fonctions affichage
		function modifier(){  // Fonction inscription
			// Recuperation des donnees 
			var prenom = document.querySelector(".profil input[name='prenom']").value;  // Selectione le premier element avec le selecteur ".inscription", input avec le nom="prenom	"
			var nom = document.querySelector(".profil input[name='nom']").value;
			var email = document.querySelector(".profil input[name='email']").value;
			var date = document.querySelector(".profil input[name='date']").value;
			var mdpold = document.querySelector(".profil input[name='mdpold']").value;
			var mdp1 = document.querySelector(".profil input[name='mdp1']").value;
			var mdp2 = document.querySelector(".profil input[name='mdp2']").value;


			// Creation de l'instance (objet)
			if(window.XMLHttpRequest){  // On verifie si on est bien sur les nouvelles versions d'internet (Firefox, Safari, Chrome...)
				var xhr = new XMLHttpRequest();  // On cree une instance
			}
			else if (window.ActiveXObject){  // Sinon, on est sur les anciennes versions d'internet explorer (IE5, IE6)
				var xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			// Traitement de la reponse
			xhr.onreadystatechange = function(){
				if(xhr.readyState === 4){  // L'etat 4 signifie que la demande est terminee et la reponse est prete
					if(xhr.status === 200){  // Le status de la requete est OK (404 signifie introuvable)
						document.getElementById("texte1").innerHTML = xhr.responseText;
					}
					else{
						document.write("Erreur code : " + xhr.status + "<br> Vous avez surement oublié de créer un serveur !");  // On ouvre une autre page si y'a erreur
					}
				
				}
			};
			
			xhr.open("POST", "modification.php", true);  // Ouvre le fichier php, avec la méthode POST, en mode ASYNCHRONE
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  // Définit l'entête de la requête HTTP

			// Prépare les données pour les envoyées à la page php sous forme de lien
			var donnee = "prenom=" + encodeURIComponent(prenom) + "&nom=" + encodeURIComponent(nom) + "&email=" + encodeURIComponent(email) 
			+ "&date=" + encodeURIComponent(date) + "&mdpold=" + encodeURIComponent(mdpold) + "&mdp1=" + encodeURIComponent(mdp1) + "&mdp2=" + encodeURIComponent(mdp2);
			// encode les donnees pour qu'elles soient envoyees
			xhr.send(donnee);  
		}

		// SCRIPT PAGE JEUNE_COMPTE

		function afficheDiv(num){
			var divs = document.getElementsByClassName("jeune_compte_div");  //Tout les divs
			for (var i = 0; i < divs.length; i++) {
				divs[i].style.display = "none";
			}
			var div = document.getElementById("div" + num);  //Le div à afficher
			div.style.display = "block";
			
		}


	</script>
</head>
<body>
	<header>
		<div class="rectangle">
			<a href="projet_jeunes_index.html"> <img class="logo" src="Images/icone1.png" alt="Logo" height="160" width="270"></a>
			<p class="titre" id="jeune">JEUNE</p> <br>
			<p class="phrase">Je donne de la valeur à mon engagement</p>
		</div>
	</header>

	<div class="menu">
		<ul>
			<li id=lien_jeune>JEUNE</li>
			<li id="referent">RÉFÉRENT</li>
			<li id="consultant">CONSULTANT</li>
			<li><a href="partenaires.html" id="partenaires">PARTENAIRES</a></li>
		</ul>
	</div>
    <div class="jeune_compte">
		<p>Bienvenue sur votre compte Jeune</p>
		<button onclick="afficheDiv(1)">Modifier/voir profil</button>
		<button onclick="afficheDiv(2)">Créer demande référence</button>
		<button onclick="afficheDiv(3)">Consulter liste référence</button>
		<button onclick="afficheDiv(4)">Envoyer référence au consultant</button>
		<button onclick="afficheDiv(5)">Inclure référence validées dans CV</button><br>
		<div id="div1" class="jeune_compte_div">
	<p>Modifier le profil</p>
	<form class="profil" method="post" action="">
		<!-- Les champs du formulaire de modification du profil -->
		<label>Prénom : </label>
		<input type="text" name="prenom" placeholder="Prénom" required/> <br>
		<label>Nom : </label>
		<input type="text" name="nom" placeholder="Nom" required/> <br>
		<label>Email : </label>
		<input type="email" name="email" placeholder="Email" required/> <br>
		<label>Date de naissance</label>
		<input type="date" name="date" placeholder="" required/> <br>
		<label>Ancien mot de Passe</label>
		<input type="password" name="mdpold" placeholder="Mot de passe" required/> <br>
		<label>Nouveau mot de Passe</label>
		<input type="password" name="mdp1" placeholder="Confirmez le mot de passe" required/> <br>
		<label>Confirmer mot de passe</label>
		<input type="password" name="mdp2" placeholder="Confirmez le mot de passe" required/> <br>
		<p id="texte1"> </p>
		<input type="submit" name="modifier" value="Enregistrer les modifications"/>
	</form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Vérifier si toutes les données ont été envoyées
	if (isset($_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["date"], $_POST["mdpold"], $_POST["mdp1"], $_POST["mdp2"])) {
		// Récupération de toutes les données
		$prenom = $_POST["prenom"];
		$nom = $_POST["nom"];
		$email = $_POST["email"];
		$date = $_POST["date"];
		$mdpold = $_POST["mdpold"];
		$mdp1 = $_POST["mdp1"];
		$mdp2 = $_POST["mdp2"];

		// Appel de la fonction de validation
		$validation = test($prenom, $nom, $email, $date, $mdp1, $mdp2);

		if ($validation === 0) {
    		echo "Erreur de validation";
		} 
		else {
			// Connexion à la base de données (vous devez remplacer les valeurs par les vôtres)
			$servername = "localhost";
			$username = "nom_utilisateur";
			$password = "mot_de_passe";
			$dbname = "nom_base_de_donnees";

			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
				die("Erreur de connexion à la base de données : " . $conn->connect_error);
		}

		// Échapper les valeurs pour éviter les injections SQL
		$prenom = $conn->real_escape_string($prenom);
		$nom = $conn->real_escape_string($nom);
		$email = $conn->real_escape_string($email);
		$date = $conn->real_escape_string($date);
		$mdp1_hash = password_hash($mdp1, PASSWORD_DEFAULT); // Hashage du nouveau mot de passe

		// Construire et exécuter la requête SQL pour mettre à jour les informations du profil
		$sql = "UPDATE user SET prenom='$prenom', nom='$nom', email='$email', date='$date', mot_de_passe='$mdp1_hash' WHERE id_utilisateur='$id_utilisateur'";
		if ($conn->query($sql) === true) {
			echo "Modifications enregistrées avec succès";
		} else {
			echo "Erreur lors de l'enregistrement des modifications : " . $conn->error;
		}

		// Fermer la connexion à la base de données
		$conn->close();
	}
  }

}
?>

		<div id="div2" class="jeune_compte_div">
			<p>Créer une demande de référence</p>
			<form method="post" action="creer_reference.php">
				<!-- Les champs du formulaire de création de demande de référence -->
				<input type="submit" value="Créer la demande">
			</form>
		</div>
		<div id="div3" class="jeune_compte_div">
			<p>Consultation de la liste de références</p>
			<a href="liste_references.php">Consulter la liste</a>
			
		</div>
		<div id="div4" class="jeune_compte_div">
			<p>Envoi des références validées au Consultant</p>
			<form method="post" action="envoyer_references.php">
				<!-- Les champs du formulaire d'envoi des références -->
				<input type="submit" value="Envoyer les références">
			</form>
		</div>
		<div id="div5" class="jeune_compte_div">
			<p>Inclusion des références validées dans votre CV</p>
			<form method="post" action="inclusion_cv.php">
				<!-- Les champs du formulaire d'inclusion des références dans le CV -->
				<input type="submit" value="Inclure les références dans le CV">
			</form>
		</div>
	    
	    
	    	<div id="div6" class="jeune_compte_div">
    			<p>Envoyer un e-mail au référent</p>
    			<form onsubmit="envoyerMailReferent(event)">
       			 <textarea id="messageReferent" placeholder="Un email a été envoyé à votre référent avec succés ! Ce dernier vous contactera prochainement. En attendant, vous pouvez continuer à visiter notre site, mofifier votre profil, ajouter des éléments à celui-ci, importer votre CV ou lettre de motivation, mettre une photo de profil, voir la liste  des référents, visiter les sites de nos partenaires de Jeune 6.4."></textarea>
        			<button type="submit">Envoyer l'e-mail</button>
    				</form>
		</div>

		<script>
   		 function envoyerMailReferent(event) {
       		 event.preventDefault(); // Empêche la soumission du formulaire

       		 var message = document.getElementById("messageReferent").value;
		
       		 // Appel AJAX pour envoyer l'e-mail au référent
       		
        		var xhr = new XMLHttpRequest();
       		 	xhr.onreadystatechange = function() {
          		  if (xhr.readyState === 4) {
                		if (xhr.status === 200) {
                  			  alert(xhr.responseText); // Affiche la réponse du serveur (par exemple, "E-mail envoyé avec succès")
               			 } else {
                   			 alert("Erreur lors de l'envoi de l'e-mail");
                		}
            		}
       		 };
        	xhr.open("POST", "URL_ENVOI_MAIL_REFERENT", true);
        	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        	xhr.send("message=" + encodeURIComponent(message));
    		}
	</script>

	</div>
	</body>
</html>
