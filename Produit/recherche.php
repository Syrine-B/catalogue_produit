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
            <link rel="stylesheet" href="affichage.css">
            <meta name="viewport" content="width=device-width">
            <title>Catalogue de Produits</title>
        </head>

        <?php
        if($_SESSION['groupe']== 'user' || $_SESSION['groupe']== 'externe' ){
        ?>
            <h1>Vous ne pouvez pas acceder à cette page</h1>
            <a href="../general.php" class="modify-button">Accueil General</a>
        <?php
        }else{
        
        ?>

            <body>
                <div>
                    <a href="accueil.php" class="button">Retour à l'accueil </a>
                    <h1>Catalogue de Produits</h1>
                    <h1>Recherche</h1>

                    <form method="POST">
                        <label for="keywords">Entrez vos mots-clés :</label>
                        <input type="text" id="keywords" name="keywords" placeholder="Entrez vos mots-clés">
                        <input type="submit" value="Rechercher">
                    </form>

                    
                    <?php
                        include 'config.php';
                        

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if(isset($_POST["keywords"])) {
                                $keywords = $_POST["keywords"];

                                // Récupération des documents correspondant aux mots-clés
                                $sql = "SELECT ID_Prod, nomDitom FROM catalogueProduit WHERE nomDitom LIKE '%" . $keywords . "%' ORDER BY nomDitom ASC";
                                $result = $conn->query($sql);

                                // Vérifier s'il y a des résultats
                                if ($result->num_rows > 0) {
                                    // Affichage des résultats de la recherche
                                    echo '<h2>Résultats de la recherche pour "' . $keywords . '":</h2>';
                                    echo '<form method="POST">'; // Formulaire pour la sélection du produit
                                    echo '<label for="selectProduct">Sélectionner un Produit :</label>';
                                    echo '<select id="selectProduct" name="selectProduct">';
                                    echo '<option value="">Sélectionnez un produit</option>';

                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["ID_Prod"] . '">' . mb_strtoupper($row["nomDitom"]) . '</option>';
                                    }
                                    
                                    echo '</select>';
                                    echo '<input type="submit" value="Voir les détails">';
                                    echo '</form>'; // Fin du formulaire pour la sélection du produit
                                    echo '</div>';
                                } else {
                                    echo '<p>Aucun produit trouvé pour "' . $keywords . '".</p>';
                                }
                            } elseif (isset($_POST['selectProduct'])) {
                                $selectedProduct = $_POST['selectProduct'];

                                $sql = "SELECT * FROM catalogueProduit WHERE ID_Prod = '$selectedProduct'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo "<div class='product'>";
                                    if (isset($row['photo'])) {
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
                            } else {
                                echo "Aucune donnée POST reçue.";
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