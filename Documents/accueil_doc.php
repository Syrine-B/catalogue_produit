<!DOCTYPE html>
<!--
Date: 13/12/23
Auteur: Syrine Benali
But: Page d'accueil d'un référentiel de document. 
Ce code permet de choisir le document dans une liste et de l'afficher.
Le document doit impérativement etre sous format PDF 
-->

<?php
session_start(); // Starts the session
if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
{
?>
<html>
<head>
<meta charset="UTF-8">
        <title>Page d'accueil</title>
        <link rel="stylesheet" href="accueil_doc.css">
<title>Consultation de documents PDF</title>
</head>
<body>
<div id="pdfListContainer">
        <?php
            if($_SESSION['groupe']== 'ditom' || ['groupe']== 'admiistrateur'){
        ?>
            <a href="../Produit/accueil.php" class="button">Catalogue Produit</a>
        <?php
        }
        ?>
            <a href="../general.php" class="button">Accueil</a>
            <?php
            if($_SESSION['groupe']== 'administrateur'){
            ?>
                <a href="affupload.php" class="button">Ajouter un document</a>
                <a href="delete.php" class="button">Supprimer un document</a>
                <?php
            }
            ?>
        
        <h1>Sélectionnez un document PDF à consulter:</h1>

        <form method="POST">
            <input type="text" name="keywords" placeholder="Entrez vos mots-clés">
            <input type="submit" value="Rechercher">
        </form>

        <?php
        include 'configuration.php'; // Inclure le fichier de configuration contenant les infos de connexion et le chemin racine

        if(isset($_POST["keywords"])) {
            $keywords = $_POST["keywords"];

            // Récupération des documents correspondant aux mots-clés
            $sql = "SELECT * FROM documents WHERE nomDoc LIKE '%" . $keywords . "%' ORDER BY nomDoc ASC";
            $resultAll = $conn->query($sql);

            // Vérifier s'il y a des résultats
            if ($resultAll->num_rows > 0) {
                // Affichage des résultats de la recherche
                echo '<h2>Résultats de la recherche pour "' . $keywords . '":</h2>';
                echo '<select id="pdfList">';
                echo '<option value="">Sélectionnez un document</option>';

                while($rowAll = $resultAll->fetch_assoc()) {
                    echo '<option value="' . $rowAll["cheminDoc"] . '">' . mb_strtoupper($rowAll["nomDoc"], 'UTF-8') . '</option>';
                }
                
                echo '</select>';
            } else {
                echo '<p>Aucun document trouvé pour "' . $keywords . '".</p>';
            }
        } else {
            // Si la recherche n'est pas utilisée, afficher tous les documents dans la liste déroulante
            $sqlAll = "SELECT nomDoc, cheminDoc FROM documents ORDER BY nomDoc ASC";
            $resultAll = $conn->query($sqlAll);

            if ($resultAll->num_rows > 0) {
                echo '<select id="pdfList">';
                echo '<option value="">Sélectionnez un document</option>';

                while($rowAll = $resultAll->fetch_assoc()) {
                    echo '<option value="' . $rowAll["cheminDoc"] . '">' . mb_strtoupper($rowAll["nomDoc"], 'UTF-8') . '</option>';
                }

                echo '</select>';
            } else {
                echo '<p>Aucun document trouvé.</p>';
            }
        }
        ?>

        <br><br>
    
        <button onclick="openPDF()">Ouvrir le document</button>

        <br><br>
        </div>
        <iframe id="pdfViewer" style="float:right;" allowfullscreen webkitallowfullscreen></iframe>

        <script>
            function openPDF() {
                var selectBox = document.getElementById("pdfList");
                var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                var pdfViewer = document.getElementById("pdfViewer");
                pdfViewer.src = selectedValue;
            }
        </script>
    </body>
<?php
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: ../Utilisateur/login.php");
}
?>
</html>