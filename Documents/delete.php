<!DOCTYPE html>
<!--
Date: 13/12/23
Auteur: Syrine Benali
But: Page d'accueil d'un référentiel de document. 
Ce code permet de supprimer un document de la table et du dossier dans lequel il est situé
-->

<html lang="fr">
<?php
session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
?> 
    <head>
        <meta charset="UTF-8">
        <title>Supprimer un document</title>
        <link rel="stylesheet" href="doc.css">
        <script>
            function showConfirmation() {
                alert("Le document a été correctement supprimé.");
                window.location.href = window.location.href; // Recharger la page
            }
        </script>
    </head>
    <?php
    if($_SESSION['groupe']!= 'administrateur'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil_doc.php" class="button">Accueil</a>
        <?php

    }else{
        ?>
    <body ALIGN=center>
        <div ALIGN=center>
            <a href="../general.php" class="button">Accueil General</a>
            <a href="../Produit/accueil.php" class="button">Catalogue Produit</a>
            <a href="accueil_doc.php" class="button">Visionner un document</a>
            <a href="upload.php" class="button">Ajouter un document</a>
        </div>
        <h1>Sélectionnez le document à supprimer :</h1>

        <form method="POST">
            <select name="documentToDelete">
                <?php
                include 'configuration.php'; 

                //Affichage de tout les éléments dans la liste
                $sql = "SELECT idDoc, nomDoc FROM documents ORDER BY nomDoc ASC";
                $result = $conn->query($sql);

                if (!$result) {
                    echo "Erreur dans la requête SQL : " . $conn->error;
                } elseif ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["idDoc"] . '">' . $row["nomDoc"] . '</option>';
                    }
                } else {
                    echo '<option value="">Aucun document trouvé</option>';
                }
                ?>
            </select>
            <input type="submit" value="Supprimer">
        </form>

        <?php
        // Traitement de la suppression du document
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["documentToDelete"])) {
                $documentId = $_POST["documentToDelete"];

                $sqlSelect = "SELECT cheminDoc FROM documents WHERE idDoc = $documentId";
                $resultSelect = $conn->query($sqlSelect);

                if ($resultSelect->num_rows > 0) {
                    $row = $resultSelect->fetch_assoc();
                    $documentPath = $row["cheminDoc"];

                    // Concaténer le chemin racine avec le chemin du document
                    $fullDocumentPath = $documentPath;

                    if (file_exists($fullDocumentPath)) {
                        // Supprimer le fichier seulement s'il existe dans le dossier cible
                        if (unlink($fullDocumentPath)) {
                            // Supprimer l'entrée de la base de données seulement si la suppression du fichier du serveur réussit
                            $sqlDelete = "DELETE FROM documents WHERE idDoc = $documentId";
                            if ($conn->query($sqlDelete) === TRUE) {
                                echo "<script>showConfirmation();</script>"; // Appeler la fonction JavaScript pour afficher la fenêtre de dialogue
                            } else {
                                echo "Erreur lors de la suppression du document de la base de données : " . $conn->error;
                            }
                        } else {
                            echo "<p>Erreur lors de la suppression du fichier du serveur.</p>";
                        }
                    } else {
                        echo "<p>Le fichier n'existe pas dans le dossier cible.</p>";
                    }
                } else {
                    echo "Aucun document trouvé avec cet identifiant.";
                }
            }
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
