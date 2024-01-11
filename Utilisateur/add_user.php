<?php

//Date: 13/12/23
//Auteur: Syrine Benali

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
include 'configuration.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'utilisateur</title>
    <link rel="stylesheet" href="design.css">
</head>
<?php
    if($_SESSION['groupe']!= 'administrateur'){ //si la personne n'est pas administrateur
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="../general.php" class="Action">Accueil</a>
        <?php

    }else{
?>
<body ALIGN=center>
    <a href="../general.php" class="Action" >Retour à l'accueil</a>
    <br><br>
    <h2>Ajout d'utilisateur:</h2>

    <form action="addUser_execute.php" method="post" enctype="multipart/form-data">
 
                    <input type="hidden" name="primkey" value="">
                    
                    <label for="groupe">Catégorie:</label>
                    <select id="groupe" name="groupe">
                        <option value="administrateur">Administrateur</option>
                        <option value="adminProduit">Externe</option>
                        <option value="ditom">Ditom</option>
                        <option value="user">User</option>
                        <option value="externe">Externe</option>
                    </select>
                    <br><br>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value=""class="large-input"><br><br>

                    <label for="prenom">Prenom :</label>
                    <input type="text" id="prenom" name="prenom" value=""class="large-input"><br><br>

                    <label for="userID">Login:</label>
                    <input type="text" id="userID" name="userID" value=""class="large-input"><br><br>

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" value=""class="large-input"><br><br>

                    <label for="mdp">Mot de passe:</label>
                    <input type="text" id="mdp" name="mdp" value=""class="large-input"><br><br>
                   
                    <br><br>

                    <input type="submit" value="Enregistrer" class="Action">
                </form>
    </body>
<?php
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: login.php");
}
?>
</html>