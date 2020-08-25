<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=vente_pieces;charset=utf8', 'root', '');
if (isset($_POST['Seconnecter'])) {

    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $cmdp = $_POST['cmdp'];
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $que = $bdd->prepare("select Email FROM utilisateur WHERE Email=? ");
    $que->execute(array($email));
    $longueur = strlen($mdp);
    if ($que->rowCount() == 1) {
        $do = $que->fetch();
        $query = $bdd->prepare("UPDATE `utilisateur` SET `MDP`=? WHERE Email=?");
        $query->execute(array($mdp, $email));
        $do = $query->fetch();
        $quer = $bdd->prepare("select * FROM utilisateur WHERE Email=? && MDP=?");
        $quer->execute(array($email, $mdp));
        if ($quer->rowCount() == 1) {
            $do = $quer->fetch();
            $_SESSION['username'] = $do['Username'];
            $_SESSION['nom1'] = $do['NomUser'];
            $_SESSION['prenom1'] = $do['Prenom'];
            $_SESSION['type'] = $do['TypeUser'];
            $_SESSION['mdpanc'] = $do['MDP'];
            $_SESSION['mailanc'] = $do['Email'];
            header('Location:ProfileP.php');
        }
    } else {
        $erreur3 = "Cet email n'existe pas";
    }
}
?>




<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/css/bootstrap.css" rel="stylesheet">
        <link href="css/css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/css/bootstrap-theme.min.css" rel="stylesheet"> 
        <style>

            #login{
                margin-top: 40px;
                background-color: #999999;
                opacity: 0.70;
                padding: 0px 60px 0px 65px;
                box-shadow: -6px -6px 7px  #666666;
                border-radius: 0px 30px 0px 30px;

            }
            .user{
                font-size: 20px;
                color: white;
            }
            .input-group-addon{
                background-color: transparent;
                border-radius: 10px 10px 10px 10px;

                color: white;
            }

            .form-control{
                background: transparent;
                border-radius: 0px;
                height: 40px;
                font-size: 15px;
                color: white;
            }
            .btn{
                background-color: #666666;
                width: 40%;
                margin-top: 10px;
                margin-left: 30px;
                border-radius:8px 8px 8px 8px;
                height: 40px;
                font-size:20px; 
                color: white;
            }

        </style>
    </head>
    <body style="background-color: #eeebeb"> 
        <div class="container">
            <br><br><br>

            <div class="row">
                <div class="col-md-6 col-md-offset-3" id="login">
                    <div class="page-header"><h3 style="color: white; text-align: center"><strong>Mot de passe oublié</strong></h3></div>
                    <form action="#" method="post" id="formdp">

                        <div class="form-group">
                            <label class="user">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input class="form-control" type="email" name="email" placeholder="Entrez votre E-mail pour réinitialiser votre Password">

                            </div>
<?php if (isset($erreur3)) { ?><p style=" color: #e51b1b; font-size: 18px;text-align: center"> <?php echo $erreur3;
} ?></p></div>


                        <div class="form-group">
                            <label class="user">Nouveau mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input class="form-control" type="password" name="mdp" id="mdp"  placeholder="Entrez votre nouveau mot de passe">
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="user">Confirmer le mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input class="form-control" type="password" name="cmdp"  placeholder="Confirmer votre nouveau mot de passe">
                                </div></div>

                            <div class="form-inline col-lg-offset-3">
                                <button type="submit" class="btn  col" name="Seconnecter" >Se connecter</button><span class="bar"></span> 

                            </div> <br>

                            </form>
                        </div>
                </div>
            </div>

            <script src="js/jquery2.js"></script>
            <script src="js/ajax13.js"></script>
            <script src="js/jquery13.js"></script>
            <script>
                $(function () {

                    $.validator.setDefaults({
                        highlight: function (element) {
                            $(element).closest('.form-group').addClass('has-error');
                        },
                        unhighlight: function (element) {
                            $(element).closest('.form-group').removeClass('has-error');
                        },
                        errorElement: 'span',
                        errorClass: 'help-block',
                        errorPlacement: function (error, element) {
                            if (element.parent('.input-group').length) {
                                error.insertAfter(element.parent());
                            } else {
                                error.insertAfter(element);
                            }
                        }
                    });
                    $.validator.addMethod('strongPassword', function (value, element) {
                        return this.optional(element)
                                || value.length >= 6
                                && /\d/.test(value)
                                && /[a-z]/i.test(value);
                    }, 'Votre mot de passe doit au minimum avoir 6 caracters et contient au moin un chiffre et un caractere\'.')

                    $("#formdp").validate({
                        rules: {

                            email: {
                                required: true,
                                email: true,
                            },
                            mdp: {
                                required: true,
                                strongPassword: true
                            },
                            cmdp: {
                                required: true,
                                equalTo: '#mdp'
                            }
                        }
                    });
                });
            </script>
    </body>
</html>

