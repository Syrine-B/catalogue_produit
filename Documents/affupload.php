<!DOCTYPE html>
<?php
session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
?>  
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'upload</title>
    <link rel="stylesheet" href="doc.css">
</head>
<?php
    if($_SESSION['groupe']!= 'administrateur'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil_doc.php" class="button">Accueil</a>
        <?php

    }else{
        ?>
        <body ALIGN = center>
            <a href="accueil_doc.php" class="button">Retour à l'accueil</a>
            <a href="delete.php" class="button modify-button">Suppression</a>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <br><br>
                <h2>Ajouter un fichier</h2>
                <br><br>
                <label for="directory">Indiquez le répertoire :</label>
                <br><br>
                <input type="text" id="directory" name="directory" required style="width: 700px;" ><br><br>
                <br><br>
                <label for="fileUpload">Fichier:</label>
                <input type="file" name="photo" id="fileUpload">
                <input type="submit" name="submit" value="Upload">
            </form>
        </body>
<?php
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: ../Utilisateur/login.php");
}
    ?>
</html>