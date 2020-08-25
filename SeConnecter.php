<?php

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
if (isset($_POST['mail']) && isset($_POST['mdp'])) {
    $email = $_POST['mail'];
    $mdp = $_POST['mdp'];
    if ($email && $mdp) {
        $query = $bdd->query("select * FROM utilisateur WHERE Email='$email'");

        if ($query->rowCount() == 1) {
            $do = $query->fetch();
            $mdph = $do['MDP'];
            if (password_verify($mdp, $mdph)) {
                $_SESSION['username'] = $do['Username'];
                $_SESSION['nom1'] = $do['NomUser'];
                $_SESSION['prenom1'] = $do['Prenom'];
                $_SESSION['type'] = $do['TypeUser'];
                $type = $do['TypeUser'];
                $_SESSION['mdpanc'] = $do['MDP'];
                $_SESSION['mailanc'] = $do['Email'];
                if ($type == 'Professionnel' || $type == 'Particulier') {
                    header('Location:ProfileP.php?id=' . $_SESSION['username']);
                } else if ($type == 'Administrateur') {
                    header('Location:Profile.php?id=' . $_SESSION['username']);
                }
            } else
                echo '<script language="JavaScript">
	alert("Votre mot de passe est incorrect. Merci de recommencer");
	window.location.replace("index.php");
	</script>';
        } else
            echo '<script language="JavaScript">
	alert("Votre adresse email est incorrect. Merci de recommencer");
	window.location.replace("index.php");
	</script>';
    } else
        echo '<script language="JavaScript">
	alert("Vous avez oublié de remplir un champ. Merci de recommencer");
	window.location.replace("index.php");
	</script>';
}
?>
