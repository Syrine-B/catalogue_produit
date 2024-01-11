<!DOCTYPE html>
<!--
Date: 13/12/23
Auteur: Syrine Benali
But: Page d'accueil général qui donne accès aux différents référentiel 
-->
<?php
session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
?>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <?php require "header.php"; ?>
        <title>Page d'accueil</title>
        <link rel="stylesheet" href="general.css">
        <img src="/Logo/logo_fnac.jpg" alt="Logo" />
    </head>
    <body ALIGN=center>
        <div ALIGN=center>
        <?php
            if($_SESSION['groupe']== 'ditom' || $_SESSION['groupe']== 'administrateur'|| $_SESSION['groupe']== 'adminProduit'){
        ?>
            <a href="Produit/accueil.php" class="button_gauche">Catalogue Produit</a>
            <?php
            }
            ?>

            <a href="Documents/accueil_doc.php" class="button_droite">Referentiel technique</a>
            
            <?php
            if($_SESSION['groupe']== 'administrateur'){
            ?>
            <a href="Utilisateur/modif_user.php" class="button_gauche">Modification utilisateur</a>
            <?php
            }
            ?>
            
        </div>
        <div ALIGN=center>
            <br><br>
        <h2>Bienvenue sur DOCNET<br>
        <?php
            if($_SESSION['groupe']== 'user'){
            ?>
            <br> Vous avez accès au référentiel technique<h2>
            <?php
            }
            else{
                ?>
                <br> Vous avez accès au référentiel technique ainsi qu'au catalogue produits<h2>
            <?php
            }
            ?>
        </div>
        <footer>
        <img src="/Logo/Logo_ED_DITOM50.png" alt="Logo" />
        </footer>
    </body>
<?php
    }
    else {
      //si la personne n'est pas connecté elle est renvoyer sur la page login
    header("Location: Utilisateur/login.php");
    }
?>
</html>