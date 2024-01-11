<!DOCTYPE html>
<!--
Date: 13/12/23
Auteur: Syrine Benali
But: Page d'accueil d'un référentiel de produit. 
-->

<html lang="fr">
<?php
session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connecté
{

?>
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="accueil.css">

</head>
<?php
    if($_SESSION['groupe']== 'user' || ['groupe']== 'externe' ){
    ?>
    <h1>Vous ne pouvez pas acceder à cette page</h1>
    <a href="../general.php" class="button_recherche">Accueil General</a>
    <?php
    }
?>
<body class="body">
    <div >
        <div ALIGN=center>
            <a href="../Documents/accueil_doc.php" class="button_recherche">Référentiel</a>
            <a href="../general.php" class="button_recherche">Accueil General</a>
            <?php
            if($_SESSION['groupe']== 'administrateur' || $_SESSION['groupe']== 'adminProduit'){
            ?>  
                <a href="modification.php" class="modify-button">Modification</a>
                <a href="suppression.php" class=" modify-button">Suppression</a>
                <a href="add.php" class=" modify-button">Ajouter</a>
            <?php
            }
            ?>
            
        </div>
        <br><br><br>

        <h1>Catalogue Produit</h1>
        <div class="dropdown" ALIGN=center>
        <br><br><br>
            <form action="affListe.php" method="post">
                <label for="selectProduct">Produit :</label>
                <select id="selectProduct" name="selectProduct">
                        <?php
                        include 'config.php'; 
                        $sql = "SELECT * FROM catalogueProduit ORDER BY nomditom ASC";
                        $result = $conn->query($sql);
                        echo "<option value='selectProduct'> Selectionner un produit</option>";

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["reference"] . "'>" . mb_strtoupper($row["nomDitom"]) . "</option>";
                            }
                        } else {
                            echo "Aucun périphérique trouvé dans la base de données.";
                        }
                        ?>
                    </select>
                <input type="submit" value="Exécuter" class="button_tous">
                <br><br><br>
                <br><br><br>
            </form>
        </div>
        <div class="main-content">
            <div class="button-container">
                <a href="periph.php" class="button_tous">Périphérique</a>
                <a href="reseaux.php" class="button_tous">Réseaux</a>
                <a href="serveur.php" class="button_tous">Serveur</a>
                <a href="ordi.php" class="button_tous">Ordinateur</a>
                <a href="connect.php" class="button_tous">Connectique</a>
                <a href="accessoire.php" class="button_tous">Accessoire</a>
                <a href="consommable.php" class="button_tous">Consommable</a>
                <a href="caisse.php" class="button_tous">Caisse</a>
                <a href="recherche.php" class="button_recherche">Recherche</a>
            </div>
        </div>

        
    </div>
    <footer>
    <img src="/Logo/Logo_ED_DITOM50.png" alt="Logo" />
    </footer>
</body>
<?php
    }
    else {
      //si la personne n'est pas connecté elle est renvoyer sur la page login
    header("Location: ../Utilisateur/login.php");
    }
    ?>
</html>