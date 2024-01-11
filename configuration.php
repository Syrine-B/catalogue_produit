<?php

//Date: 13/12/23
//Auteur: Syrine Benali
//But: Centraliser les différentes variable necessaire dans d'autre codes 

$servername = "localhost";
$username = "root";
$password = "M@g@s1nDT!";
$dbname = "referentiel";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname,);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

?>
