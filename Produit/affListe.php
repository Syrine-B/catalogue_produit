<!DOCTYPE html>

<!--
Date: 13/12/23
Auteur: Syrine Benali
But: Permet d'afficher le produit choisit
-->
<html lang="fr">
    <?php
    session_start(); // Starts the session
    if(isset($_SESSION['prenom'])) //verifie si la personne est connecté
    {

    ?>
        <head>
            <meta charset="UTF-8">
            <title>Affichage du produit</title>
            <link rel="stylesheet" href="affichage.css">
        </head>
        <?php
        if($_SESSION['groupe']== 'user' || ['groupe']== 'externe' ){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="../general.php" class="modify-button">Accueil General</a>
        <?php
        }
        else{
        ?>
            <body>
                <a href="accueil.php" class = "button" >Retour à l'accueil</a>
                <h1>Affichage du produit</h1>

                <div id="productContainer">
                <?php

                include 'config.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['selectProduct'])) {

                        $selectedProduct = $_POST['selectProduct'];

                        $sql = "SELECT * FROM catalogueProduit WHERE reference = '$selectedProduct'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<div class='product'>";
                            echo "<h2>Attributs du produit sélectionné :</h2>";
                            echo "<ul>";
                            if(isset($row['photo'])) {
                                echo "<img src='" . $dossierPhoto ."/". $row['photo'] . "' alt='" . $row['nomDitom'] . "'>";
                            }
                            if(isset($row['nomDitom'])) {
                                echo "<h2>" . $row['nomDitom'] . "</h2>";
                            }
                            if(isset($row['details'])) { 
                                echo "<p>Détails:" . $row['details'] . "</p>";
                            }
                            if(isset($row['dimension'])) { 
                                echo "<p>Dimensions (mm) : " . $row['dimension'] . "</p>";
                            }
                            if(isset($row['poids'])) { 
                                echo "<p>Poids (g) : " . $row['poids'] . "</p>";
                            }
                            
                            if(isset($row['reference'])) { 
                                echo "<p>Ref: " . $row['reference'] . "</p>";
                            }
                            if(isset($row['constructeur'])) { 
                                echo "<p>Constructeur: " . $row['constructeur'] . "</p>";
                            }
                            if(isset($row['nomFournisseur'])) { 
                                echo "<p>Nom de l'article fournisseur: " . $row['nomFournisseur'] . "</p>";
                            }
                            if(isset($row['necessite'])) { 
                                echo "<p>Necessite: " . $row['necessite'] . "</p>";
                            }
                            if(isset($row['utilite'])) { 
                                echo "<p>Utilite: " . $row['utilite'] . "</p>";
                            }
                            
                            echo "</div>";
                            echo "</ul>";
                        } else {
                            echo "Aucun attribut trouvé pour ce produit.";
                        }
                    } else {
                        echo "Aucun produit sélectionné.";
                    }
                } else {
                    echo "Aucune méthode de requête POST détectée.";
                }
                ?>

                </div>
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
