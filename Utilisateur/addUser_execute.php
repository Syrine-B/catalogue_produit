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

        // Fonction pour envoyer l'e-mail
        function envoyerEmail($login, $motDePasse, $destinataire) {
            $adresseExpediteur = $_SESSION['email'];
            $sujet = 'Activation de votre compte dans le portail DITOM';
            $message = "Bonjour,\n\nVotre compte a été créé avec succès.\n\nVoici vos détails de connexion.\n\nLogin: $login\nMot de passe: $motDePasse\n\nPour rappel voilà le lien pour le portail: http://10.176.2.66";

            // En-têtes pour spécifier l'expéditeur et le type de contenu
            $headers = 'From: ' . $adresseExpediteur . "\r\n" .
                'Reply-To: ' . $adresseExpediteur . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Envoi de l'e-mail
            if (mail($destinataire, $sujet, $message, $headers)) {
                echo "E-mail envoyé avec succès à $destinataire";
            } else {
                echo "Échec de l'envoi de l'e-mail à $destinataire";
                // Autre logique à appliquer en cas d'échec d'envoi
                // Par exemple, enregistrement dans un fichier de logs, notification à l'administrateur, etc.
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['primkey'];
            $nom = $_POST['nom'];
            $groupe = $_POST['groupe'];
            $prenom = $_POST['prenom'];
            $userID = $_POST['userID'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

            $sql = "INSERT INTO UTILISATEUR (nom, prenom, groupe, userID, email, mdp) VALUES ('$nom', '$prenom', '$groupe', '$userID', '$email', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                // Envoi de l'e-mail avec les détails du compte
                envoyerEmail($userID, $mdp, $email);

                $message = "Nouvel utilisateur ajouté avec succès. Un e-mail a été envoyé avec les détails du compte.";
                echo "<script>alert('$message'); window.location.href = 'add_user.php';</script>";
                exit(); 
            } else{
                echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
            }

        }
    }
}
else {
    //si la personne n'est pas connecté elle est renvoyer sur la page login
header("Location: login.php");
}
?>
