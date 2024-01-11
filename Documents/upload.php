<?php

session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
    if($_SESSION['groupe']!= 'administrateur'){
        ?>
        <h1>Vous ne pouvez pas acceder à cette page</h1>
        <a href="accueil.php" class="button">Accueil</a>
        <?php

    }else{

        include 'configuration.php';


        // Vérifier si le formulaire a été soumis
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $chemin = "Referentiel";
            $directory = $_POST["directory"];
            $directoryfinal = $chemin . $directory;
            $fileName = basename($_FILES["photo"]["name"]);
            $targetfile = $directoryfinal . $fileName;

            
            // Vérifie si le fichier a été uploadé sans erreur.
            if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){      
                // Vérifie si le fichier existe avant de le télécharger.
                if(file_exists($directoryfinal . $_FILES["photo"]["name"])){
                    echo $_FILES["photo"]["name"] . " existe déjà.";
                } else{
                    // Vérifier si le fichier est un PDF
                    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if ($fileType !== "pdf") {
                        echo '<script>';
                        echo 'alert("Seuls les fichiers PDF sont autorisés.");';
                        echo 'window.location.href = "affupload.php";';
                        echo '</script>';
                        exit(); // Arrête le script si ce n'est pas un PDF
                    }else{
                    
                        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $directoryfinal . $_FILES["photo"]["name"])) {

                            $fileNameInDB = mysqli_real_escape_string($conn, $fileName);
                            $sqlCheck = "SELECT nomDoc FROM documents WHERE nomDoc = '$fileNameInDB'";
                            $resultCheck = $conn->query($sqlCheck);
            
                            // Enregistrement dans la base de données
                            $relativePathInDB = mysqli_real_escape_string($conn, $targetfile);
            
                            $sqlInsert = "INSERT INTO documents (nomDoc, cheminDoc) VALUES ('$fileNameInDB', '$relativePathInDB')";
            
                            if ($conn->query($sqlInsert) === TRUE) {
                                // Afficher la boîte de dialogue et rediriger vers accueil_doc.php après validation
                                echo '<script>';
                                echo 'alert("Fichier correctement enregistré.");';
                                echo 'window.location.href = "affupload.php";';
                                echo '</script>';
                            } else {
                                echo "Erreur lors de l'enregistrement dans la base de données : " . $conn->error;
                            }
            
                            
                        } else {
                            echo "Désolé, une erreur s'est produite lors de l'upload de votre fichier.";
                        }
                    }
                }
            }
        }
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: ../Utilisateur/login.php");
}

?>