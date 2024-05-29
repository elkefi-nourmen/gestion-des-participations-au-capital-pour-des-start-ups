<?php
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbco->prepare("SELECT * FROM projet WHERE id_startuper = :id_startuper");
$stmt->bindParam(':id_startuper', $_SESSION['user_id']);
$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projet</title>
    <link rel="stylesheet" href="projet.css" />
    <script>
    function selectRow(id) {
        console.log("Selected row ID: " + id);
        showProjectDetails(id);
    }

    function showProjectDetails(id) {
        var editerProjet = document.getElementById("editer_projet");
        var projects = <?php echo json_encode($projets); ?>;
        var project = projects.find(p => p.id_projet == id);
        if (project) {
            editerProjet.innerHTML = `
                <table border="1" >
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Nombre d'actions à vendre</th>
                            <th>Prix d'un action</th>
                            <th>Nombre d'actions restent à vendre</th>
                            <th>Montant collecté</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${project.titre}</td>
                            <td>${project.description}</td>
                            <td>${project.nombre_actions_a_vendre}</td>
                            <td>${project.prix_action}</td>
                            <td>${project.nombre_actions_a_vendre - project.nombre_actions_vendues}</td>
                            <td>${project.prix_action * project.nombre_actions_vendues}</td>
                        </tr>
                    </tbody>
                </table>
            `;
            editerProjet.style.display = "block";
        }
    }

    function deleteProjet(id) {
    var projects = <?php echo json_encode($projets); ?>;
    var project = projects.find(p => p.id_projet == id);
    if (project.nombre_actions_vendues > 0) {
        alert('Vous ne pouvez pas supprimer ce projet car des actions ont déjà été vendues.');
        return;
    }

    if (confirm('Êtes-vous sûr de vouloir supprimer ce projet?')) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert('Projet supprimé avec succès!');
                    window.location.reload();
                } else {
                    alert('Une erreur s\'est produite lors de la suppression du projet.');
                }
            }
        };
        xhr.open('POST', 'supprimer_projet.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('id=' + id);
    }
}

</script>

</head>
<body>
<?php
    if (isset($_SESSION['error_message'])) {
        echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
        unset($_SESSION['error_message']); 
    }
    ?>
    <div class="container">
        <header>
    <h1>InnovFin</h1>
        </header>
        <nav>
    <ul>
        <li><a href="acceuil-start.html">Acceuil</a></li>
        <li><a href="profil_start.php">Mon Profil</a></li>
        <li><a href="projet_start.php">Projets</a></li>
        <li><a href="welcome.html">Se deconnecter</a></li>
    
    </ul>
        </nav>
    <div class="contenu">



        <form  action="nouveau_projet.php" method="post" id="form2" class="form">

            <div class="form-group">
                <h2>Creer un projet :</h2>
                <div class="formcontainer">
                    <label for="titre">Le titre :</label>
                    <input type="text" name="titre" id="titre" class="form-control">
                    <label for="description">Description :</label>
                    <textarea id="description" name="description" rows="5" cols="50" class="form-control"></textarea>

                    <label for="nb_actions">Nombre d'actions à vendre:</label>
                    <input type="text" name="nb_actions" id="nb_actions" class="form-control">
    
                    <label for="montant">Valeur monétaire de l'action :</label>
                    <input type="text" name="montant" id="montant" class="form-control">

                    <div class="button-container">
                        <button type="submit" class="btn btn-primary col-6">Enregistrer</button>
    
                    </div>
                </div>
            </div>
    
            <p id='erreur'></p>
        </form>


        <div class="form-group" id="tous_projets">
                <h2>Vos Projets :</h2>
                <table id="projets_table" border="1">
                    <thead>
                        <tr>
                        <th colspan="2">Titre</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projets as $projet): ?>
                            <tr onclick="selectRow(<?php echo $projet['id_projet']; ?>)">
                                <td><?php echo $projet['titre']; ?></td>
                                <td> <button id="supprimer_button" onclick="deleteProjet('<?php echo $projet['id_projet']; ?>')">Supprimer</button>  </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="editer_projet" style="display: none;">
        <table border="1">
            <thead>
                <tr>
                    <th>Titre </th>
                    <th>Description</th>
                    <th>Nombre d'actions à vendre</th>
                    <th>Prix d'un action</th>
                    <th>Nombre d'actions restent à vendre</th>
                    <th>Montant collecté</th>

                </tr>
            </thead>
          
        </table>
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
        </div>
        <script src='projet.js' method='POST'></script>

</body>
</html> 