<?php session_start();

$servname = "localhost";
$dbname = "startupinvest";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $dbco->prepare("SELECT * FROM startuper WHERE id_startuper = :id");
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $dbco->prepare("SELECT photo FROM startuper WHERE id_startuper = :id");
$stmt2->bindParam(':id', $_SESSION['user_id']);
$stmt2->execute();
$imageData = $stmt2->fetchColumn();

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="profil.css" />

</head>
<body>
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


        <form  action="profile.php" method="post" enctype="multipart/form-data" id="form1" class="form">

            <div class="form-group">
            <img src="uploads/<?php echo $user['photo']; ?>" alt="User Photo" width="100" id="profile_picture">

                <div class="formcontainer">
                   
    
                    <label for="nom">Votre nom :</label>
                    <input type="text" name="nom" id="nom" class="form-control"  value="<?php echo isset($user['nom']) ? $user['nom'] : ''; ?>">
    

                    <label for="prenom">Votre prénom :</label>
                    <input type="text" name="prenom" id="prenom" class="form-control"value="<?php echo isset($user['prenom']) ? $user['prenom'] : ''; ?>">

                    <label for="pseudo">Votre pseudo :</label>
                    <input type="text" name="pseudo" id="pseudo" class="form-control"value="<?php echo isset($user['pseudo']) ? $user['pseudo'] : ''; ?>">

                    <label for="cin">Numéro CIN (8 chiffres) :</label>
                    <input type="text" name="cin" id="cin" class="form-control"value="<?php echo isset($user['cin']) ? $user['cin'] : ''; ?>">
    
                    <label for="email">Votre email :</label>
                    <input type="email" name="email" id="email" class="form-control"value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
    
                    <label for="entreprise">Nom de l'entreprise :</label>
                    <input type="text" name="entreprise" id="entreprise" class="form-control"value="<?php echo isset($user['nom_entreprise']) ? $user['nom_entreprise'] : ''; ?>">
    
                    <label for="adresse">Adresse de l'entreprise :</label>
                    <input type="text" name="adresse" id="adresse" class="form-control"value="<?php echo isset($user['adresse_entreprise']) ? $user['adresse_entreprise'] : ''; ?>">
    
                    <label for="registre">Numéro du registre de commerce :</label>
                    <input type="text" name="registre" id="registre" class="form-control"value="<?php echo isset($user['numero_registre_commerce']) ? $user['numero_registre_commerce'] : ''; ?>">
    
                    <label for="photo">Photo d'identité :</label>
                    <input type="file" name="photo" id="photo" class="form-control"><br>
    
                   
    
                    <label for="password"> Votre mot de passe  :</label>
                    <input type="password" name="password" id="password" class="form-control"value="<?php echo isset($user['pwrd']) ? $user['pwrd'] : ''; ?>"><br>
                    
    
                    <div class="button-container">
        <button type="submit" class="btn btn-primary col-6" name="modifier">Modifier</button>
  
                    </div>
                </div>
            </div>
    
            <p id='erreur'></p>
        </form>
    </div></div>
    <footer>
<h3>InnovFin</h3>
<div class="logo">
    <img src="facebook.png" alt="logo"/>
    <img src="instagram.png" alt="logo"/>
    <img src="youtube.png" alt="logo"/>
    <img src="tiktok.png" alt="logo"/>
</div>
    </footer>
        <script src='inscrit-start.js' method='POST'></script>
    
    
    </body>
</html>
