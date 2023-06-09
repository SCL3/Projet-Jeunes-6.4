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
		function connex(){  // Fonction connexion
			// Recuperation des donnees 
			var email = document.querySelector(".connexion input[name='email']").value;
			var mdp = document.querySelector(".connexion input[name='mdp']").value;

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
			
			xhr.open("POST", "connexion_jeune.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  // Définit l'entête de la requête HTTP
			
			// Prépare les données pour les envoyées à la page php sous forme de lien
			var donnee = "email=" + encodeURIComponent(email) + "&mdp=" + encodeURIComponent(mdp);

			// encode les donnees pour qu'elles soient envoyees
			xhr.send(donnee);  // null pour une requete get
		}

		function inscript(){  // Fonction inscription
			// Recuperation des donnees 
			var prenom = document.querySelector(".inscription input[name='prenom']").value;  // Selectione le premier element avec le selecteur ".inscription", input avec le nom="prenom	"
			var nom = document.querySelector(".inscription input[name='nom']").value;
			var email = document.querySelector(".inscription input[name='email']").value;
			var date = document.querySelector(".inscription input[name='date']").value;
			var mdp1 = document.querySelector(".inscription input[name='mdp1']").value;
			var mdp2 = document.querySelector(".inscription input[name='mdp2']").value;


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
						document.getElementById("texte2").innerHTML = xhr.responseText;
					}
					else{
						document.write("Erreur code : " + xhr.status + "<br> Vous avez surement oublié de créer un serveur !");  // On ouvre une autre page si y'a erreur
					}
				
				}
			};
			
			xhr.open("POST", "inscription_jeune.php", true);  // Ouvre le fichier php, avec la méthode POST, en mode ASYNCHRONE
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  // Définit l'entête de la requête HTTP

			// Prépare les données pour les envoyées à la page php sous forme de lien
			var donnee = "prenom=" + encodeURIComponent(prenom) + "&nom=" + encodeURIComponent(nom) + "&email=" + encodeURIComponent(email) 
			+ "&date=" + encodeURIComponent(date) + "&mdp1=" + encodeURIComponent(mdp1) + "&mdp2=" + encodeURIComponent(mdp2);
			// encode les donnees pour qu'elles soient envoyees
			xhr.send(donnee);  
		}

		// SCRIPT PAGE JEUNE_COMPTE

		function afficheDiv(num){
			var div1 = document.getElementById('div1');  //Récupération des div de la page
            var div2 = document.getElementById('div2');
			var div3 = document.getElementById('div3');
			var div4 = document.getElementById('div4');
			var div5 = document.getElementById('div5');

			switch (num){
				case 1:
					div1.style.display = 'block';  //On affiche le div qu'on veut
           			div2.style.display = 'none';
					div3.style.display = 'none';
					div4.style.display = 'none';
					div5.style.display = 'none';
					break;
				case 2:
					div1.style.display = 'none';  //On affiche le div qu'on veut
					div2.style.display = 'block';
					div3.style.display = 'none';
					div4.style.display = 'none';
					div5.style.display = 'none';
					break;
				case 3:
					div1.style.display = 'none';  //On affiche le div qu'on veut
					div2.style.display = 'none';
					div3.style.display = 'block';
					div4.style.display = 'none';
					div5.style.display = 'none';
					break;
				case 4:
					div1.style.display = 'none';  //On affiche le div qu'on veut
					div2.style.display = 'none';
					div3.style.display = 'none';
					div4.style.display = 'block';
					div5.style.display = 'none';
					break;
				case 5:
					div1.style.display = 'none';  //On affiche le div qu'on veut
					div2.style.display = 'none';
					div3.style.display = 'none';
					div4.style.display = 'none';
					div5.style.display = 'block';
					break;
				default:
					break;
			}
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
			<li><a href="referent.html" id="referent">RÉFÉRENT</a></li>
			<li><a href="consultant.html" id="consultant">CONSULTANT</a></li>
			<li><a href="partenaires.html" id="partenaires">PARTENAIRES</a></li>
		</ul>
	</div>
    <div>
		<p>Bienvenue sur votre compte Jeune</p>
		<button onclick="afficheDiv(1)">Modifier/voir profil</button>
		<button onclick="afficheDiv(2)">Créer demande référence</button>
		<button onclick="afficheDiv(3)">Consulter liste référence</button>
		<button onclick="afficheDiv(4)">Envoyer référence au consultant</button>
		<button onclick="afficheDiv(5)">Inclure référence validées dans CV</button><br>
		<div>

		</div id="div1" class="jeune_compte_div">
			<p>Modifier le profil</p>
			<form method="post" action="modifier_profil.php">
				<!-- Les champs du formulaire de modification du profil -->
				<input type="submit" value="Enregistrer les modifications">
			</form>
			<p>Créer une demande de référence</p>
			<form method="post" action="creer_reference.php">
				<!-- Les champs du formulaire de création de demande de référence -->
				<input type="submit" value="Créer la demande">
			</form>
			<p>Consultation de la liste de références</p>
			<a href="liste_references.php">Consulter la liste</a>
			<p>Envoi des références validées au Consultant</p>
			<form method="post" action="envoyer_references.php">
				<!-- Les champs du formulaire d'envoi des références -->
				<input type="submit" value="Envoyer les références">
			</form>
			<p>Inclusion des références validées dans votre CV</p>
			<form method="post" action="inclusion_cv.php">
				<!-- Les champs du formulaire d'inclusion des références dans le CV -->
				<input type="submit" value="Inclure les références dans le CV">
			</form>
		</div>
		</div id="div2" class="jeune_compte_div">
			oui
		</div>
		</div id="div3" class="jeune_compte_div">
			ouioui
		</div>
		</div id="div4" class="jeune_compte_div">
			ouiouioui
		</div>
		</div id="div5" class="jeune_compte_div">
			ouiouiouioui
		</div>
	</div>
	</body>
</html>
