<!DOCTYPE html>
<!--
Date: 13/12/23
Auteur: Syrine Benali
-->
<html lang="fr">
    <?php
    session_start(); // Starts the session
    if(isset($_SESSION['prenom'])) //verifie si la personne est connécté
    {
    include 'configuration.php';
    ?>
        <head>
            <link rel="stylesheet" href="design.css">
            <meta charset="UTF-8">
            <title>Modification Utilisateur</title>
            <br><br>
        </head>
        <div ALIGN = center>
        <?php
        if($_SESSION['groupe']!= 'administrateur'){ //si la personne n'est pas administrateur
            ?>
            <h1>Vous ne pouvez pas acceder à cette page</h1>
            <a href="../general.php" class="button">Accueil</a>
            <?php

        }else{
        ?>
        </div>
            <body ALIGN=center>
                <a href="../general.php" class="button">Retour à l'accueil</a>
                <br><br>
                <a href="add_user.php" class = "Action">Ajouter un utilisateur</a>
                <?php
                $sql = "SELECT * FROM UTILISATEUR";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                ?>
                    <h2>Choisissez l'utilisateur à modifier :</h2>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="selectUser">Utilisateur :</label>
                        <select id="selectUser" name="selectedUser">
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["primkey"] . "'>" . $row["userID"] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" value="Sélectionner" class="Action">
                    </form>

                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedUser'])) {
                        $selectedUserId = $_POST['selectedUser'];

                        $selectedUserQuery = "SELECT * FROM UTILISATEUR WHERE primkey = $selectedUserId";
                        $selectedUserResult = $conn->query($selectedUserQuery);

                        if ($selectedUserResult->num_rows > 0) {
                            $row = $selectedUserResult->fetch_assoc();
                    ?>
                            <h2>Modifier l'utilisateur "<?php echo $row['userID']; ?>"</h2>
                            <form action="change_user.php" method="post">

                                <input type="hidden" name="primkey" value="<?php echo $row['primkey']; ?>">
                                
                                <label for="groupe">Groupe:</label>
                                <select id="groupe" name="groupe">
                                    <option value="administrateur" <?php if ($row['groupe'] === 'administrateur') echo 'selected'; ?>>Administrateur</option>
                                    <option value="adminProduit" <?php if ($row['groupe'] === 'adminProduit') echo 'selected'; ?>>Administateur Produit</option>
                                    <option value="ditom" <?php if ($row['groupe'] === 'ditom') echo 'selected'; ?>>Ditom</option>
                                    <option value="user" <?php if ($row['groupe'] === 'user') echo 'selected'; ?>>User</option>
                                    <option value="externe" <?php if ($row['groupe'] === 'externe') echo 'selected'; ?>>Externe</option>
                                </select>
                                <br><br>

                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" value="<?php echo $row['nom']; ?>"class="large-input"><br><br>

                                <label for="prenom">Prénom :</label>
                                <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>"class="large-input"><br><br>

                                <label for="userID">Login:</label>
                                <input type="text" id="userID" name="userID" value="<?php echo $row['userID']; ?>"class="large-input"><br><br>

                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>"class="large-input"><br><br>

                                <label for="mdp">Mot de passe:</label>
                                <input type="text" id="mdp" name="mdp" value=""class="large-input"><br><br>

                                <input type="submit" value="Enregistrer les Modifications" class="Action">
                            </form>

                            <!-- Formulaire de suppression -->
                            <form action="delete_user.php" method="post" onsubmit="return confirmDeletion()">
                                <input type="hidden" name="primkey" value="<?php echo $selectedUserId; ?>">
                                <input type="submit" value="Supprimer le compte" class="Action">
                            </form>

                            <script>
                            function confirmDeletion() {
                                var confirmation = confirm('Êtes-vous sûr de vouloir supprimer l\'utilisateur <?php echo $row['userID']; ?> ?');
                                if (confirmation) {
                                    return true; // Soumission du formulaire si OK
                                } else {
                                    return false; // Annulation de la soumission si Annuler
                                }
                            }
                            </script>
                    <?php
                        } else {
                            echo "<p>Aucun utilisateur trouvé avec cet identifiant.</p>";
                        }
                    }
                } else {
                    echo "Aucun utilisateur trouvé.";
                }
                ?>                
            </body>
    <?php
        }
    }
    else {
        //si la personne n'est pas connecté elle est renvoyer sur la page login
    header("Location: login.php");
    }
    ?>
</html>
