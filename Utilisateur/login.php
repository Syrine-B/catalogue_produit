<?php
//Date: 13/12/23
//Auteur: Syrine Benali

include 'configuration.php';
    ini_set('display_errors',1);
    error_reporting(E_ALL);

    if(isset($_POST['connexion']))
    {
        if(isset($_POST['userID']) && isset($_POST['password']))
        {
            $userID = $_POST['userID'];
            $password =$_POST['password'];
            if($userID !== "" && $password !== "")
            {
            // connexion à la base de données
                //  Récupération de l'utilisateur et de son pass hashé
                $req = $conn->prepare('SELECT * FROM UTILISATEUR WHERE userID = ?');
                $req->bind_param("s", $userID); // Liaison du paramètre
                $result = $req->execute(); // Exécution de la requête

                if (!$result) {
                    die('Erreur lors de l\'exécution de la requête : ' . $req->error); // Gestion de l'erreur d'exécution
                }

                $resultat = $req->get_result()->fetch_assoc(); // Récupération des résultats

                if (!$resultat) {
                    echo 'Mauvais identifiant ou mot de passe !';
                    // Redirection après avoir affiché le message
                    header("Refresh: 3; url=login.php"); // Redirige vers login.php après 3 secondes
                    exit;
                } else {
                
                    // Comparaison du mot de passe envoyé via le formulaire avec la base
                    $isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp']);
                    if ($isPasswordCorrect) {
                        session_start();
                        $_SESSION['id'] = $resultat['idUser'];
                        $_SESSION['prenom'] = $resultat['prenom'];
                        $_SESSION['nom'] = $resultat['nom'];
                        $_SESSION['groupe'] = $resultat['groupe'];
                        $_SESSION['userID'] = $resultat['userID'];
                        $_SESSION['email'] = $resultat['email'];
                        header("Location: ../general.php");
                        echo 'Vous êtes connecté !';
                    }
                    else {
                        echo 'Mauvais identifiant ou mot de passe !';
                        // Redirection après avoir affiché le message
                        header("Refresh: 3; url=login.php"); // Redirige vers login.php après 3 secondes
                        exit;
                    }
                }

            }
        }
    }
?>


<html>
    <head>
       <meta charset="utf-8">
        <link rel="stylesheet" href="login.css?t=<? echo time(); ?>" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
        <form action="login.php" method="POST">
            <h1>Connexion</h1>

            <label><b>Login</b></label>
            <input type="text" placeholder="Entrer votre login" name="userID" required>

            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" required>

            <input type="submit" name='connexion' value='Connexion'>
        </form>
        </div>
    </body>
</html>