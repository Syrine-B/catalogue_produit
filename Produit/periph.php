<!DOCTYPE html>

<!--
Date: 13/12/23
Auteur: Syrine Benali
-->

<html lang="fr">
    <?php
    session_start(); // Starts the session
    if(isset($_SESSION['prenom'])) //verifie si la personne est connecté
    {

    ?>
        <head>
            <meta charset="UTF-8">
            <title>Catalogue de Produits</title>
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
                <div>
                    <a href="accueil.php" class="button">Retour à l'accueil </a>
                    <h1>Catalogue de Produits</h1>
                    <h1>Peripherique</h1>

                    <label for="selectProduct">Sélectionner un Produit :</label>
                    <form method="post">
                        <select id="selectProduct" name="selectProduct">
                            <?php
                            include 'config.php';

                            $sql = "SELECT nomDitom, Reference FROM catalogueProduit WHERE categorie = 'peripherique' ORDER BY nomditom ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["Reference"] . "'>" . mb_strtoupper($row["nomDitom"]) . "</option>";
                                }
                            } else {
                                echo "Aucun périphérique trouvé dans la base de données.";
                            }
                            ?>
                        </select>
                        <input type="submit" value="Afficher les détails">
                    </form>
                </div>

                <div id="productContainer">
                    <?php


                        // Affichage des détails du produit sélectionné
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['selectProduct'])) {
                            $selectedProduct = $_POST['selectProduct'];

                            $sql = "SELECT * FROM catalogueProduit WHERE Reference = '$selectedProduct'";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo "<div class='product'>";
                                if(isset($row['photo'])) {
                                    echo "<img src='" . $dossierPhoto . "/" . $row['photo'] . "' alt='" . $row['nomDitom'] . "'>";
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
                                    echo "<p>Nom fournisseur: " . $row['nomFournisseur'] . "</p>";
                                }
                                if(isset($row['necessite'])) { 
                                    echo "<p>Necessite: " . $row['necessite'] . "</p>";
                                }
                                if(isset($row['utilite'])) { 
                                    echo "<p>Utilite: " . $row['utilite'] . "</p>";
                                }
                                
                                echo "</div>";
                            } else {
                                echo "Aucun détail trouvé pour ce produit.";
                                if(!$result) {
                                    echo "Erreur dans la requête : " . $conn->error;
                                }
                            }
                        }
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
