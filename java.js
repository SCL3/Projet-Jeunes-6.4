const urlParams = new URLSearchParams(window.location.search);
const userId = urlParams.get('userId');

const requestUser = new XMLHttpRequest();
requestUser.open('GET', `https://api.jeunes64.fr/users/${userId}`);
requestUser.onload = function() {
  const user = JSON.parse(requestUser.responseText);
  document.getElementById('nom').textContent = user.nom;
  document.getElementById('prenom').textContent = user.prenom;
  document.getElementById('age').textContent = user.age;
  document.getElementById('ville').textContent = user.ville;
};
requestUser.send();

const requestReferences = new XMLHttpRequest();
requestReferences.open('GET', `https://api.jeunes64.fr/references?userId=${userId}&status=validated`);
requestReferences.onload = function() {
  const references = JSON.parse(requestReferences.responseText);
  const referencesBody = document.getElementById('references');
  references.forEach(function(reference) {
    const row = document.createElement('tr');
    const nom = document.createElement('td');
    nom.textContent = reference.referentNom;
    row.appendChild(nom);
    const prenom = document.createElement('td');
    prenom.textContent = reference.referentPrenom;
    row.appendChild(prenom);
    const email = document.createElement('td');
    email.textContent = reference.referentEmail;
    row.appendChild(email);
    const relation = document.createElement('td');
    relation.textContent = reference.relation;
    row.appendChild(relation);
    referencesBody.appendChild(row);
  });
};
requestReferences.send();
