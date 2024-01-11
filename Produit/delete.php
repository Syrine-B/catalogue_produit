<?php

//Date: 13/12/23
//Auteur: Syrine Benali

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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['productIdToDelete'];

            if (!empty($id)) {
                $sqlphoto = "SELECT photo FROM catalogueProduit WHERE ID_Prod = $id";
                $result = $conn->query($sqlphoto);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $oldFileName = $row['photo'];
                    $oldFilePath = $dossierPhotoenr . '/' . $oldFileName;

                    // Suppression de la photo et des données dans la base de données
                    if (file_exists($oldFilePath) && unlink($oldFilePath)) {
                        $sql = "DELETE FROM catalogueProduit WHERE ID_Prod=$id";
                        if ($conn->query($sql) === TRUE) {
                            echo "<script>
                                    if(confirm('Suppression réussie de la photo et des données dans la base de données')) {
                                        window.location = 'suppression.php';
                                    }
                                </script>";
                        } else {
                            echo "<script>
                                    if(confirm('Erreur lors de la suppression dans la base de données : " . $conn->error . "')) {
                                        window.location = 'suppression.php';
                                    }
                                </script>";
                        }
                    } else {
                        echo "<script>
                                if(confirm('Erreur lors de la suppression du fichier ou le fichier n\'existe pas')) {
                                    window.location = 'suppression.php';
                                }
                            </script>";
                    }
                } else {
                    echo "<script>
                            if(confirm('Aucune photo trouvée pour cet ID de produit')) {
                                window.location = 'suppression.php';
                            }
                        </script>";
                }
            } else {
                echo "<script>
                        if(confirm('Aucune suppression spécifiée')) {
                            window.location = 'suppression.php';
                        }
                    </script>";
            }
        }
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: ../Utilisateur/login.php");
}
?>