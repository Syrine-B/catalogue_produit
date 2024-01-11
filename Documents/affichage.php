<!DOCTYPE html>

<!--
Date: 13/12/23
Auteur: Syrine Benali
-->

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="doc.css">
</head>
<body class="body" >
    <div ALIGN=center>
        <a href="../Produit/accueil.php" class="button">Catalogue Produit</a>
        <a href="../general.php" class="button">Accueil General</a>
        <a href="password.php?action=ajouter" class="button">Ajouter un document</a>
        <a href="password.php?action=supprimer" class="button">Supprimer un document</a>
        <br><br><br><br><br><br><br><br><br>
    
        <?php
        include 'configuration.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['selectedDoc'];

            $sql = "SELECT nomDoc, cheminDoc FROM documents WHERE idDoc = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $nomFichier = $row['nomDoc'];
                $emplacementactuel = $row['cheminDoc'];
                $dossierTemporaire = '/tmp'."/";
                $source = $emplacementactuel;
                $destination = $dossierTemporaire . $nomFichier;

                if (copy($source, $destination)) {
                    echo 'Fichier copier avec succès vers le dossier temporaire.';
                    echo '<embed src="' . $dossierTemporaire . $nomFichier . '" type="application/pdf" width="100%" height="600px" />';
                } else {
                    echo 'Erreur lors du déplacement du fichier vers le dossier temporaire.';
                }
            } else {
                echo 'Aucun résultat trouvé pour cet ID.';
            }
        }
        ?>
    </div>
</body>
</html>