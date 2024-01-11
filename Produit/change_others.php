<?php
//Date: 13/12/23
//Auteur: Syrine Benali
//But: Changer les attribut d'un produit sauf la photo 

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
            $id = $_POST['ID_Prod'];
            $nomDitom = $_POST['nomDitom'];
            $categorie = $_POST['categorie'];
            $details = $_POST['details'];
            $dimension = $_POST['dimension'];
            $poids = $_POST['poids'];
            $reference = $_POST['reference'];
            $constructeur = $_POST['constructeur'];
            $nomFournisseur = $_POST['nomFournisseur'];
            $necessite = $_POST['necessite'];
            $utilite = $_POST['utilite'];

            $otherFieldsUpdated = false; // Variable pour suivre la modification des autres champs

            $updates = [];
            if (!empty($nomDitom)) {
                $updates[] = "nomDitom='$nomDitom'";
                $otherFieldsUpdated = true;
            }
            if (!empty($categorie)) {
                $updates[] = "categorie='$categorie'";
                $otherFieldsUpdated = true;
            }
            if (!empty($details)) {
                $updates[] = "details='$details'";
                $otherFieldsUpdated = true;
            }
            if (!empty($dimension)) {
                $updates[] = "dimension='$dimension'";
                $otherFieldsUpdated = true;
            }
            if (!empty($poids)) {
                $updates[] = "poids='$poids'";
                $otherFieldsUpdated = true;
            }
            if (!empty($reference)) {
                $updates[] = "reference='$reference'";
                $otherFieldsUpdated = true;
            }
            if (!empty($constructeur)) {
                $updates[] = "constructeur='$constructeur'";
                $otherFieldsUpdated = true;
            }
            if (!empty($nomFournisseur)) {
                $updates[] = "nomFournisseur='$nomFournisseur'";
                $otherFieldsUpdated = true;
            }
            if (!empty($necessite)) {
                $updates[] = "necessite='$necessite'";
                $otherFieldsUpdated = true;
            }
            if (!empty($utilite)) {
                $updates[] = "utilite='$utilite'";
                $otherFieldsUpdated = true;
            }

            if (!empty($updates)) {
                $sql = "UPDATE catalogueProduit SET " . implode(", ", $updates) . " WHERE ID_Prod=$id";
                if ($conn->query($sql) === TRUE) {
                    if ($otherFieldsUpdated) {
                        echo "<script>
                                if(confirm('Modification effectuée avec succès! ')) {
                                    window.location = 'modification.php';
                                }
                            </script>";
                    } else {
                        echo "<script>
                                if(confirm('Aucune modification apportée à la base de données. ')) {
                                    window.location = 'modification.php';
                                }
                            </script>";
                    }
                } else {
                    echo "<script>
                            if(confirm('Erreur lors de la mise à jour: " . $conn->error . " ')) {
                                window.location = 'modification.php';
                            }
                        </script>";
                }
            } else {
                echo "<script>
                        if(confirm('Aucune modification spécifiée. ')) {
                            window.location = 'modification.php';
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

