<!DOCTYPE html>

<!--
Date: 13/12/23
Auteur: Syrine Benali
-->

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="affichage.css">
    <title>Suppression Produit</title>
</head>
<?php
session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
    if($_SESSION['groupe']!= 'administrateur'&& $_SESSION['groupe']!= 'adminProduit'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil.php" class="button">Accueil</a>
        <?php
    }else{
        ?>
        <body>
            <a href="accueil.php" class="button" >Retour à l'accueil</a>
            <a href="modification.php" class="button modify-button">Modification</a>
            <a href="add.php" class="button modify-button">Ajouter</a>
            <?php
            include 'config.php';
            $sql = "SELECT * FROM catalogueProduit";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            ?>
                <h2>Choisissez le produit à supprimer :</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="selectProduct">Produit :</label>
                    <select id="selectProduct" name="selectedProduct">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["ID_Prod"] . "'>" . $row["nomDitom"] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Sélectionner">
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedProduct'])) {
                    $selectedProductId = $_POST['selectedProduct'];

                    $selectedProductQuery = "SELECT * FROM catalogueProduit WHERE ID_Prod = $selectedProductId";
                    $selectedProductResult = $conn->query($selectedProductQuery);

                    if ($selectedProductResult->num_rows > 0) {
                        $row = $selectedProductResult->fetch_assoc();
                ?>
                        <h2>Supprimer le produit "<?php echo $row['nomDitom']; ?>"</h2>
                        <div class='product'>
                        <?php
                            if(isset($row['photo'])) {
                                echo "<img class='product-image' src='" . $dossierPhoto . "/" . $row['photo'] . "' alt='" . $row['nomDitom'] . "'>";
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
                            ?>
                        </div>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="productIdToDelete" value="<?php echo $row['ID_Prod']; ?>">
                            <input type="submit" value="Supprimer le produit" class = "button">
                        </form>
                <?php
                    } else {
                        echo "<p>Aucun produit trouvé avec cet identifiant.</p>";
                    }
                }
            } else {
                echo "Aucun produit trouvé.";
            }
            ?>
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