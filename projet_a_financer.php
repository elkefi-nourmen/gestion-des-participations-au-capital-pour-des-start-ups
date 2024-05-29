<?php
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbco->prepare("SELECT * FROM projet ");
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projet</title>
    <link rel="stylesheet" href="actions.css" />
    <script>
       function rechercherProjet() {
    var recherche = document.getElementById("recherche").value.trim().toLowerCase();
    var projets = <?php echo json_encode($projets); ?>;
    var filteredProjets = projets.filter(p => p.description.toLowerCase().includes(recherche));

    var projetsTable = document.getElementById("projets_table").getElementsByTagName('tbody')[0];
    projetsTable.innerHTML = "";
    filteredProjets.forEach(projet => {
        var row = projetsTable.insertRow();
        var cell = row.insertCell();
        cell.innerHTML = projet.titre;
        row.onclick = function() {
            selectRow(projet.id_projet);
        };
    });
}
function acheterActions(id_projet) {
    var actionsAcheter = parseInt(document.getElementById("actions_acheter").value);

    if (!Number.isInteger(actionsAcheter) || actionsAcheter <= 0) {
        alert("svp entrez un nombre entier superieur à 0");
        return;
    }

    var projet = <?php echo json_encode($projets); ?>.find(p => p.id_projet == id_projet);
    var nombreActionsRestentAVendre = projet.nombre_actions_a_vendre - projet.nombre_actions_vendues;

    if (actionsAcheter > nombreActionsRestentAVendre) {
        alert("Nombre d'actions superieur que le nombre disponible");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Achat avec succées!");
            window.location.reload(); 
        }
    };
    xhttp.open("POST", "acheter_actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id_projet=" + id_projet + "&actions_acheter=" + actionsAcheter);
}






        function selectRow(id) {
            var editerProjet = document.getElementById("editer_projet");
            var projet = <?php echo json_encode($projets); ?>.find(p => p.id_projet == id);
            if (projet) {
                editerProjet.innerHTML = `
                    <table border="1">
                        <thead>
                            <tr>
                            <th>Titre</th>
                                <th>Description</th>
                                <th>Prix d'un action</th>
                                <th>Nombre d'actions restent à vendre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>${projet.titre}</td>
                                <td>${projet.description}</td>
                                <td>${projet.prix_action}</td>
                                <td>${projet.nombre_actions_a_vendre - projet.nombre_actions_vendues}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="achat">
                        <label for="actions_acheter">Nombre d'actions à acheter :</label>
                        <input type="text" id="actions_acheter">
                        <button onclick="acheterActions(${projet.id_projet})">Acheter</button>
                    </div> `;
                editerProjet.style.display = "block";
            }
        }

    </script>
</head>
<body>
    <div class="container">
        <header>
            <h1>InnovFin</h1>
        </header>
        <nav>
            <ul>
                <li><a href="acceuil-cap.html">Acceuil</a></li>
                <li><a href="projets_finances.php">Projets Financés</a></li>
                <li><a href="projet_a_financer.php">Projets à Financer</a></li>
                <li><a href="welcome.html">Se deconnecter</a></li>
            </ul>
        </nav>
        <div class="contenu">
            <div class="form-group" id="recherche_projet">
                <h2>Rechercher un projet :</h2>
                <div class="formcontainer">
                    <label for="recherche">Entrez des mots pour la recherche :</label>
                    <input type="text" name="recherche" id="recherche" class="form-control">
                    <div class="button-container">
                        <button type="button" class="btn btn-primary col-6" onclick="rechercherProjet()">Rechercher</button>
                    </div>
                </div>
            </div>
            <div class="form-group" id="projets">
                <h2>Vos Projets :</h2>
                <table id="projets_table" border="1">
                    <thead>
                        <tr>
                            <th>Titre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projets as $projet): ?>
                            <tr onclick="selectRow(<?php echo $projet['id_projet']; ?>)">
                                <td><?php echo $projet['titre']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="editer_projet" style="display: none;"></div>
        </div>
    </div>
    <footer>
        <h3>InnovFin</h3>
        <div class="logo">
            <img src="facebook.png" alt="logo"/>
            <img src="instagram.png" alt="logo"/>
            <img src="youtube.png" alt="logo"/>
            <img src="tiktok.png" alt="logo"/>
        </div>
    </footer>
</body>
</html>
