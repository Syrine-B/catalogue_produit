<?php

//Date: 13/12/23
//Auteur: Syrine Benali
//But: Formulaire d'ajout produit dans la base

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
?> 
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajout de Produit</title>
        <link rel="stylesheet" href="affichage.css">
    </head>
    <?php
    if($_SESSION['groupe']!= 'administrateur'&& $_SESSION['groupe']!= 'adminProduit'){ //si la personne n'est pas administrateur
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil.php" class="button">Accueil</a>
        <?php

    }else{
        include 'config.php';
        $sql = "SELECT * FROM catalogueProduit";
        $result = $conn->query($sql);
    ?>
        <body>
            <a href="accueil.php" class="button" >Retour à l'accueil</a>
            <a href="modification.php" class="button modify-button">Modification</a>
            <a href="suppression.php" class="button modify-button">Suppression</a>
            <h2>Ajout de produit :</h2>

            <form action="add_execute.php" method="post" enctype="multipart/form-data">
        
                <input type="hidden" name="ID_Prod" value="">
                
                <label for="categorie">Catégorie:</label>
                <select id="categorie" name="categorie">
                    <option value="peripherique">Périphérique</option>
                    <option value="reseaux">Réseaux</option>
                    <option value="serveur">Serveur</option>
                    <option value="ordinateur">Ordinateur</option>
                    <option value="connectique">Connectique</option>
                    <option value="accessoire">Accessoire</option>
                    <option value="caisse">Caisse</option>
                    <option value="consommable">Consommable</option>
                </select>
                <br><br>
                <label for="nomDitom">Nom Ditom du Produit :</label>
                <input type="text" id="nomDitom" name="nomDitom" value=""class="large-input"><br><br>

                <label for="details">Détails du Produit :</label>
                <input type="text" id="details" name="details" value=""class="large-input"><br><br>

                <label for="dimension">Dimensions du Produit:</label>
                <input type="text" id="dimension" name="dimension" value=""class="large-input"><br><br>

                <label for="poids">Poids du Produit:</label>
                <input type="text" id="poids" name="poids" value=""class="large-input"><br><br>

                <label for="reference">Référence du Produit:</label>
                <input type="text" id="reference" name="reference" value=""class="large-input"><br><br>

                <label for="constructeur">Constructeur du Produit:</label>
                <input type="text" id="constructeur" name="constructeur" value=""class="large-input"><br><br>

                <label for="nomFournisseur">Nom du Fournisseur:</label>
                <input type="text" id="nomFournisseur" name="nomFournisseur" value=""class="large-input"><br><br>

                <label for="necessite">Autre produit necessaire au fonctionnement:</label>
                <input type="text" id="necessite" name="necessite" value=""class="large-input"><br><br>

                <label for="utilite">Cadre utilisation du Produit:</label>
                <input type="text" id="utilite" name="utilite" value=""class="large-input"><br><br>

                <input type="file" id="photo" name="photo" accept="image/*" class="button"><br><br>
                
                <br><br>

                <input type="submit" value="Enregistrer" class="button">
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