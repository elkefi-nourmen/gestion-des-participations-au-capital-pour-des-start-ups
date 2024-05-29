<?php
session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbco->prepare("SELECT * FROM capital_risque_projet WHERE id_capital_risque = :id_capital_risque");
$stmt->bindParam(':id_capital_risque', $_SESSION['user_id']);
$stmt->execute();
$projets_capital_risque = $stmt->fetchAll(PDO::FETCH_ASSOC);

$projets_finances = array();
foreach ($projets_capital_risque as $projet_capital_risque) {
    $stmt2 = $dbco->prepare("SELECT * FROM projet WHERE id_projet = :id_projet");
    $stmt2->bindParam(':id_projet', $projet_capital_risque['id_projet']);
    $stmt2->execute();
    $projet_finance = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($projet_finance) {
        $projets_finances[] = $projet_finance;
    }
}
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
    var projects = <?php echo json_encode($projets_finances); ?>;
    var project = projects.find(p => p.id_projet == id);
    if (project) {
        var projet_capital_risque = <?php echo json_encode($projets_capital_risque); ?>;
        var capital_risque_info = projet_capital_risque.find(p => p.id_projet == id);
        if (capital_risque_info) {
            var nombre_actions_achetees = capital_risque_info.nombre_actions_achetees;
            var prix_total = project.prix_action * nombre_actions_achetees;

            editerProjet.innerHTML = `
                <table border="1" >
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Nombre d'actions achetées</th>
                            <th>Prix total d'investement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${project.titre}</td>
                            <td>${nombre_actions_achetees}</td>
                            <td>${prix_total}</td>
                        </tr>
                    </tbody>
                </table>
            `;
            editerProjet.style.display = "block";
        }
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



       

        <div class="form-group" id="tous_projets">
                <h2>Vos Projets :</h2>
                <table id="projets_table" border="1">
                    <thead>
                        <tr>
                        <th colspan="2">Titre</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projets_finances as $projet): ?>
                            <tr onclick="selectRow(<?php echo $projet['id_projet']; ?>)">
                                <td><?php echo $projet['titre']; ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="editer_projet" style="display: none;">
        <table border="1">
            <thead>
                <tr>
                <th>Titre</th>
                            <th>Nombre d'actions achetées</th>
                            <th>Prix total d'investement</th>
                </tr>
            </thead>
            <tbody>
           
            </tbody>
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
