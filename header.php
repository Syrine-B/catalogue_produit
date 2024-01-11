<!DOCTYPE html>
<header>

	<link rel="stylesheet" href="header.css?t=<? echo time(); ?>" media="screen" type="text/css" />

	<table id="bandeau" border="0">
        <tr>
			<td class=logout>
                <br><br>
                <input style="border-radius: 10px;" type="button" name="sedeco" onclick="self.location.href='Utilisateur/deconnexion.php';" value='Se déconnecter' >
                <br><br>
			    <?php // Tester si l'utilisateur est connecte
                    if($_SESSION['prenom'] !== ""){
                        $user = $_SESSION['prenom'];
                        // Afficher un message
                        echo "Bonjour $user";
                    }
			    ?>
			</td>
        </tr>
	</table>
</header>