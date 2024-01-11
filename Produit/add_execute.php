<?php

//Date: 13/12/23
//Auteur: Syrine Benali
//But: executable pour l'ajoutt de produit dans la base 

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
    if($_SESSION['groupe']!= 'administrateur' && $_SESSION['groupe']!= 'adminProduit'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil.php" class="button">Accueil</a>
        <?php

    }else{

        include 'config.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $categorie = $_POST['categorie'];
            $nomDitom = $_POST['nomDitom'];
            $details = $_POST['details'];
            $dimension = $_POST['dimension'];
            $poids = $_POST['poids'];
            $reference = $_POST['reference'];
            $constructeur = $_POST['constructeur'];
            $nomFournisseur = $_POST['nomFournisseur'];
            $necessite = $_POST['necessite'];
            $utilite = $_POST['utilite'];

            // Vérification et traitement de l'image
            if (isset($_FILES['photo'])) {

                $photo = $_FILES['photo'];
                $fileExtension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
                $allowedExtensions = array("jpg", "jpeg", "png", "gif");

                if (in_array($fileExtension, $allowedExtensions)) {
                    $targetPath = $dossierPhotoenr;
                    $newFileName = basename($photo['name']);
                    $targetFilePath = $targetPath . "/" . $newFileName;

                    if (move_uploaded_file($photo['tmp_name'], $targetFilePath)) {
                        $sql = "INSERT INTO catalogueProduit (categorie, nomDitom, details, dimension, poids, reference, constructeur, nomFournisseur, necessite, utilite, photo) VALUES ('$categorie', '$nomDitom', '$details', '$dimension', '$poids', '$reference', '$constructeur', '$nomFournisseur', '$necessite', '$utilite', '$newFileName')";

                        if ($conn->query($sql) === TRUE) {
                            $message = "Nouveau produit ajouté avec succès.";
                            echo "<script>alert('$message'); window.location.href = 'add.php';</script>";
                            exit(); 
                        } else{
                            echo "Erreur lors de l'ajout du produit : " . $conn->error;
                        }
                    } else {
                        echo "Une erreur s'est produite lors du chargement du fichier.";
                    }
                }else{
                    echo "la photo n'a pas le bon format";
                }
            } else {
                echo "Le fichier photo n'a pas été correctement envoyé.";
            }

        } else {
            echo "Le formulaire n'a pas été soumis.";
        }
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: ../Utilisateur/login.php");
}
?>
