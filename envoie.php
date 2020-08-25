<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
$us = $_SESSION['username']; // c'est le username de l'emetteur de message qui est dans la  page profile 
if (isset($_SESSION['username']) And ! empty($_SESSION['username'])) {
    if (isset($_POST['envoie'])) {
        if (isset($_POST['des'], $_POST['message']) and ! empty($_POST['des']) and ! empty($_POST['message'])) { // isset pour l'existance des champs et empty si pour remplire les champs
            $emE = $_SESSION['mailanc'];  // l'email de l'emetteur de message
            if ($_POST['des'] == $emE) {
                $erreur = 'vouz ne pouvez pas envoyer un message a cet email ';
            } else {
                $destinaitaire = htmlspecialchars($_POST['des']); // securisé
                $message = htmlspecialchars($_POST['message']);
                $objet = htmlspecialchars($_POST['objetm']);
                $id_des = $bdd->prepare('SELECT MDP,Username FROM utilisateur WHERE Email=?');   //de la table utilisateur pour savoir le username de destinaitaire
                $id_des->execute(array($_POST['des']));
                $id_exs = $id_des->rowCount();
                if ($id_exs == 1) {
                    $id_des = $id_des->fetch();
                    $id_des1 = $id_des['Username'];
                    $id_des2 = $id_des['MDP'];
                    /* var_dump($id_des1); */// juste pour assurer la selection 
                    //echo $us."  a envoyée un message a  "  .$id_des1;
                    $ins = $bdd->prepare("INSERT INTO `message`(`idMsg`, `ContenuMsg`, `Objet`, `Date`, `Etat`, `idEmetteur`) VALUES (?,?,?,?,?,?)");
                    $ins->execute(array('', $message, $objet, '', 'non lu', $us));

                    $qu = $bdd->prepare('SELECT max(idMsg) as idMsg FROM message WHERE idEmetteur=?');
                    $qu->execute(array($us));
                    $qu = $qu->fetch();
                    $id = $qu['idMsg'];

                    // echo '  et id message est  '.$id;

                    $ins2 = $bdd->prepare("INSERT INTO `recevoir`(`idRecepteur`, `idMsg`) VALUES(?,?) ");
                    $ins2->execute(array($id_des1, $id));
                    $erreur = "votre msg a bien etait envoyer";
                } else {
                    $erreur = "le destinataire n'existe pas";
                }
            }
        } else {
            $erreur = "vous n'avez pas saisi tout les champs";
        }
    }
    $dess = $bdd->query('SELECT Email FROM utilisateur ORDER BY Email');
//requete
//select * from ma_table where rownum >= all 
//( 
//select * from ma_table order by rownum asc 
//);
    $que = $bdd->prepare('SELECT *  FROM message WHERE idEmetteur=?');
    $que->execute(array($us));
    $msg_nbr = $que->rowCount();
    ?>




    <html>
        <head>
            <title>TODO supply a title</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="css/css/bootstrap.min.css" rel="stylesheet">  

        </head>
        <body>

            <br>   
            <div class="col-lg-10 col-lg-offset-3">
                <div class="col-lg-12 ">
                    <ul class="nav nav-pills" > 
                        <li class="active"><a href="#part" role="tab" data-toggle="tab">nouveau message </a></li>
                        <li class="nav-item"><a href="#par" role="tab" data-toggle="tab">les message envoyés</a></li>

                    </ul>
                    <br><br>
                    <div class="tab-content">
                        <div role="tabpanel" class="row-fluid tab-pane active" id="part">
                            <div class="container">
                                <div class="col-md-7">
                                    <div class="well">
                                        <form class="form-horizontal" method="POST">
                                          <!--  <select name="des">
    <?php while ($d = $dess->fetch()) { ?>     
                                                    <option> <?= $d['Email'] ?></option> 
                                            <?php } ?>
                                            </select>  -->
                                            <div class="form-group row-fluid">
                                                <label  for="email" > E-mail</label>
                                                <input  class="form-control" type="text" id="email" name="des">  
                                            </div> 
                                            <div class="form-group row-fluid">
                                                <label  for="objet" > Objet</label>
                                                <input  class="form-control" type="text" id="objet" name="objetm">  
                                            </div> 
                                            <div class="form-group row-fluid">
                                                <label class="control-label " for="adresse" >Contenu message</label>

                                                <textarea rows=4 class="form-control"  id="adresse" name="message"></textarea><br>
                                                <button type="submit"  class="btn btn-default" name="envoie"> Envoyer</button><br>
    <?php if (isset($erreur)) {
        echo $erreur;
    } ?>
                                            </div>


                                        </form></div></div></div>         
                        </div>
                        <div role="tabpanel" class="row-fluid tab-pane " id="par">
                            <?php
                            if ($msg_nbr == 0) {
                                echo "vous n'avez envoyé aucun message";
                            } else
                                while ($m = $que->fetch()) {
                                    $b = $bdd->prepare('SELECT idRecepteur FROM recevoir WHERE idMsg=?');
                                    $b->execute(array($m['idMsg'])); // on l'utilise qu'on est dans un profile*/
                                    $b = $b->fetch();
                                    $id_des = $b['idRecepteur'];
                                    ?>  
                                    vous avez envoyé: 
                                    <?= "   " . $m['ContenuMsg'] . "\t       " . "a " . $id_des ?> 

                                    <br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br> 

                                <?php } ?>     
                        </div>


                    </div></div></div>

            <script src="js/jquery-latest.js"></script>
            <script src="js/js/bootstrap.min.js"></script>  
        </body>
    </html>

<?php } ?>