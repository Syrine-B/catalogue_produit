<?php

//Date: 13/12/23
//Auteur: Syrine Benali

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <link rel="stylesheet" href="affichage.css">
        <meta charset="UTF-8">
        <title>Modification Produit</title>
    </head>
    <?php
    if($_SESSION['groupe']!= 'administrateur'&& $_SESSION['groupe']!= 'adminProduit'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil.php" class="button">Accueil</a>
        <?php

    }else{
            include 'config.php';

            $sql = "SELECT * FROM catalogueProduit ORDER BY nomDitom ASC";
            $result = $conn->query($sql);
            ?>
    <body>
        <a href="accueil.php" class="button">Retour à l'accueil</a>
        <a href="suppression.php" class="button modify-button">Suppression</a>
        <a href="add.php" class="button modify-button">Ajouter</a>
        <?php
        if ($result->num_rows > 0) {
        ?>
            <h2>Choisissez le produit à modifier :</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="selectProduct">Produit :</label>
                <select id="selectProduct" name="selectedProduct">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["ID_Prod"] . "'>" . $row["nomDitom"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Sélectionner" class="button">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedProduct'])) {
                $selectedProductId = $_POST['selectedProduct'];

                $selectedProductQuery = "SELECT * FROM catalogueProduit WHERE ID_Prod = $selectedProductId ";
                $selectedProductResult = $conn->query($selectedProductQuery);

                if ($selectedProductResult->num_rows > 0) {
                    $row = $selectedProductResult->fetch_assoc();
            ?>
                    <h2>Modifier le produit "<?php echo $row['nomDitom']; ?>"</h2>
                    <form action="change_others.php" method="post">

                        <input type="hidden" name="ID_Prod" value="<?php echo $row['ID_Prod']; ?>">
                        
                        <label for="categorie">Catégorie:</label>
                        <select id="categorie" name="categorie">
                            <option value="peripherique" <?php if ($row['categorie'] === 'peripherique') echo 'selected'; ?>>Périphérique</option>
                            <option value="reseaux" <?php if ($row['categorie'] === 'reseaux') echo 'selected'; ?>>Réseaux</option>
                            <option value="serveur" <?php if ($row['categorie'] === 'serveur') echo 'selected'; ?>>Serveur</option>
                            <option value="ordinateur" <?php if ($row['categorie'] === 'ordinateur') echo 'selected'; ?>>Ordinateur</option>
                            <option value="connectique" <?php if ($row['categorie'] === 'connectique') echo 'selected'; ?>>Connectique</option>
                            <option value="caisse" <?php if ($row['categorie'] === 'caisse') echo 'selected'; ?>>Caisse</option>
                            <option value="accessoire" <?php if ($row['categorie'] === 'accessoire') echo 'selected'; ?>>Accessoire</option>
                            <option value="consommable" <?php if ($row['categorie'] === 'consommable') echo 'selected'; ?>>Consommable</option>
                        </select>
                        <br><br>

                        <label for="nomDitom">Nom Ditom du Produit :</label>
                        <input type="text" id="nomDitom" name="nomDitom" value="<?php echo $row['nomDitom']; ?>"class="large-input"><br><br>

                        <label for="details">Détails du Produit :</label>
                        <input type="text" id="details" name="details" value="<?php echo $row['details']; ?>"class="large-input"><br><br>

                        <label for="dimension">Dimensions du Produit:</label>
                        <input type="text" id="dimension" name="dimension" value="<?php echo $row['dimension']; ?>"class="large-input"><br><br>

                        <label for="poids">Poids du Produit:</label>
                        <input type="text" id="poids" name="poids" value="<?php echo $row['poids']; ?>"class="large-input"><br><br>

                        <label for="reference">Référence du Produit:</label>
                        <input type="text" id="reference" name="reference" value="<?php echo $row['reference']; ?>"class="large-input"><br><br>

                        <label for="constructeur">Constructeur du Produit:</label>
                        <input type="text" id="constructeur" name="constructeur" value="<?php echo $row['constructeur']; ?>"class="large-input"><br><br>

                        <label for="nomFournisseur">Nom du Fournisseur:</label>
                        <input type="text" id="nomFournisseur" name="nomFournisseur" value="<?php echo $row['nomFournisseur']; ?>"class="large-input"><br><br>

                        <label for="necessite">Autre produit necessaire au fonctionnement:</label>
                        <input type="text" id="necessite" name="necessite" value="<?php echo $row['necessite']; ?>"class="large-input"><br><br>

                        <label for="utilite">Cadre utilisation du Produit:</label>
                        <input type="text" id="utilite" name="utilite" value="<?php echo $row['utilite']; ?>"class="large-input"><br><br>


                        
                        <a href="change_photo.php?ID_Prod=<?php echo $row['ID_Prod']; ?>" class = "button">Modifier la photo</a>
                        <br><br>

                        <input type="submit" value="Enregistrer les Modifications" class="button">
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
