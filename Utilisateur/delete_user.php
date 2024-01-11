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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['primkey'])) {
            $primkey = $_POST['primkey'];

            // Requête pour supprimer l'utilisateur de la base de données
            $deleteQuery = "DELETE FROM UTILISATEUR WHERE primkey = $primkey";

            if ($conn->query($deleteQuery) === TRUE) {
                echo "<script>
                        if(confirm('L'utilisateur a été supprimé avec succès.')) {
                            window.location = 'modif_user.php';
                        }
                    </script>";
                
            } else {
                echo "Erreur lors de la suppression de l'utilisateur : " . $conn->error;
            }
        } else {
            // Redirection si les données ne sont pas correctement envoyées
            header("Location: modif_user.php");
        }
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: login.php");
}
?>
