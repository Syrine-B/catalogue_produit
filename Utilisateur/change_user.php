<?php
//Date: 13/12/23
//Auteur: Syrine Benali

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
    if($_SESSION['groupe']!= 'administrateur'){ //si la personne n'est pas administrateur
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="../general.php" class="button">Accueil</a>
        <?php

    }else{

        include 'configuration.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['primkey'];
            $nom = $_POST['nom'];
            $groupe = $_POST['groupe'];
            $prenom = $_POST['prenom'];
            $userID = $_POST['userID'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $otherFieldsUpdated = false; // Variable pour suivre la modification des autres champs

            $updates = [];
            if (!empty($nom)) {
                $updates[] = "nom='$nom'";
                $otherFieldsUpdated = true;
            }
            if (!empty($groupe)) {
                $updates[] = "groupe='$groupe'";
                $otherFieldsUpdated = true;
            }
            if (!empty($prenom)) {
                $updates[] = "prenom='$prenom'";
                $otherFieldsUpdated = true;
            }
            if (!empty($userId)) {
                $updates[] = "userId='$userId'";
                $otherFieldsUpdated = true;
            }
            if (!empty($email)) {
                $updates[] = "email='$email'";
                $otherFieldsUpdated = true;
            }
            if (!empty($mdp)) {
                $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
                $updates[] = "mdp='$hashedPassword'";
                $otherFieldsUpdated = true;
            }

            if (!empty($updates)) {
                $sql = "UPDATE UTILISATEUR SET " . implode(", ", $updates) . " WHERE primkey=$id";
                if ($conn->query($sql) === TRUE) {
                    if ($otherFieldsUpdated) {
                        echo "<script>
                                if(confirm('Modification effectuée avec succès! ')) {
                                    window.location = 'modif_user.php';
                                }
                            </script>";
                    } else {
                        echo "<script>
                                if(confirm('Aucune modification apportée à la base de données. ')) {
                                    window.location = 'modif_user.php';
                                }
                            </script>";
                    }
                } else {
                    echo "<script>
                            if(confirm('Erreur lors de la mise à jour: " . $conn->error . " ')) {
                                window.location = 'modif_user.php';
                            }
                        </script>";
                }
            } else {
                echo "<script>
                        if(confirm('Aucune modification spécifiée. ')) {
                            window.location = 'modif_user.php';
                        }
                    </script>";
            }
        }
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: login.php");
}
?>

