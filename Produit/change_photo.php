<?php

//Date: 13/12/23
//Auteur: Syrine Benali
//But: Changer la photo d'un produit

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
    if($_SESSION['groupe']!= 'administrateur'&& $_SESSION['groupe']!= 'adminProduit'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil.php" class="button">Accueil</a>
        <?php

    }else{

        include 'config.php';

        $id = $_GET['ID_Prod'];
        $message = ""; // Message à afficher dans la boîte de dialogue

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($id)) {
                // Vérifier s'il y a un fichier envoyé
                if (isset($_FILES['photo'])) {
                    $file = $_FILES['photo'];

                    // Obtenir l'extension du fichier
                    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowedExtensions = array("jpg", "jpeg", "png", "gif");

                    if (in_array($fileExtension, $allowedExtensions)) {

                        $targetPath = $dossierPhotoenr;

                        // Obtenir uniquement le nom du fichier sans le chemin complet
                        $newFileName = basename($file['name']);
                        $targetFilePath = $targetPath . '/' . $newFileName;

                        // Supprimer l'ancienne photo s'il y en a une
                        $sql = "SELECT photo FROM catalogueProduit WHERE ID_Prod = $id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $oldFileName = $row['photo'];

                            // Construire le chemin absolu de l'ancienne photo
                            $oldFilePath = $dossierPhotoenr . '/' . $oldFileName;

                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);
                            }
                        }

                        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                            // Mettre à jour la base de données avec le nouveau nom de la photo pour le produit ayant l'ID $id
                            $sql = "UPDATE catalogueProduit SET photo = '$newFileName' WHERE ID_Prod = $id";
                            if ($conn->query($sql) === TRUE) {
                                $message = "Photo modifiée avec succès.";
                            } else {
                                $message = "Échec de la modification.";
                            }
                        } else {
                            $message = "Une erreur s'est produite lors du chargement du fichier.";
                        }
                    } else {
                        $message = "Seuls les fichiers JPEG, PNG et GIF sont autorisés.";
                    }
                } else {
                    $message = "Aucun fichier sélectionné.";
                }
            } else {
                $message = "Erreur : ID du produit non spécifié.";
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="affichage.css">
            <title>Changer la photo</title>
            <a href="accueil.php" class="button">Retour à l'accueil</a>
            <a href="modification.php" class="button">Retour aux modifications</a>
            <script>
                // Fonction pour afficher la boîte de dialogue
                function afficherBoiteDialogue(message) {
                    var confirmation = confirm(message);
                    if (!confirmation) {
                        location.reload(); // Recharger la page si l'utilisateur clique sur Annuler
                    }
                }
                // Appel de la fonction avec le message spécifique
                window.onload = function() {
                    var message = "<?php echo $message; ?>";
                    if (message !== "") {
                        afficherBoiteDialogue(message);
                    }
                };
            </script>
        </head>
        <body>
            <h2>Changer la photo du produit</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ID_Prod" value="<?php echo $id; ?>">

                <label for="photo">Nouvelle photo :</label>
                <input class="button" type="file" id="photo" name="photo" accept="image/*"><br><br>

                <input type="submit" class= "button" value="Changer la photo" onclick="return afficherBoiteDialogue();">
            </form>

            <script>
                function afficherBoiteDialogue() {
                    var message = "<?php echo $message; ?>";

                    if (message !== "") {
                        var confirmation = confirm(message);
                        if (!confirmation) {
                            return false; // Recharger la page si l'utilisateur clique sur Annuler
                        } else {
                            if (message.includes('succès')) {
                                window.location.href = 'modification.php'; // Rediriger vers modification.php en cas de succès
                            } else {
                                location.reload(); // Recharger la page en cas d'échec
                            }
                        }
                    }
                }
            </script>
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
