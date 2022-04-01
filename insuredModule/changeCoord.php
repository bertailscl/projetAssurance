<!DOCTYPE html>
<html lang="fr">

<head>
    <title>MultiplAssur'</title>
    <meta charset="UTF-8">
    <meta name="description" content="MultiplAssur'">
    <meta name="author" content="Bertails Clément/Maurer Pierrick/Longuet Maxime/Darrigrand Fabien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="../I-Car.css" /> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="../assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="../assets/css/smoothproducts.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
</head>

<body onload="resetForm()">
    <?php
    //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    session_start();
    if (isset($_SESSION["profile"])) {
        if ($_SESSION["profile"] != 'insured') {
            switch ($_SESSION["profile"]) {
                case 'police':
                    header('Location: ../policeModule/policeHome.php?errorLogin=noAuthorized');
                    exit();
                    break;

                case 'admin':
                    header('Location: ../adminModule/adminHome.php?errorLogin=noAuthorized');
                    exit();
                    break;

                case 'manager':
                    header('Location: ../managerModule/managerHome.php?errorLogin=noAuthorized');
                    exit();
                    break;

                default:
                    session_unset();
                    header('Location: ../visitorModule/connection.php?errorConnection=notConnect');
                    exit();
                    break;
            }
        }
    } else {
        session_unset();
        header('Location: ../visitorModule/connection.php?errorConnection=notConnect');
        exit();
    }
    ?>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container">
            <p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link text-light" href="insuredHome.php"><i class=" text-light fas fa-home mr-3"></i>Accueil</a></li>
                    <li><a id='link' class="nav-link text-light" href='declareDisaster.php'>Déclarer sinistre</a></li>
                    <li><a id='link' class="nav-link text-light" href='sellVehicle.php'>Vente</a></li>
                    <li><a id='link' class="nav-link text-light" href='historyDisaster.php'> Historique sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='insuredMail.php'></i> Messagerie</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
        <?php
        echo ('<br><br><br><br>');
        echo ('
                <section class="clean-block clean-faq">
                    <div class="container">
                        <div class="block-heading">
                            <h2 class="text-info ">Bonjour ' . $_SESSION["login"] . '!</h2>
            ');
        // echo ('<p>Bonjour ' . $_SESSION["login"] . '!</p>');
        //affiche un message si l'assuré essaye d'atteindre une page dans laquelle il n'a pas les droits
        if (isset($_GET['errorLogin'])) {
            if ($_GET['errorLogin'] == "noAuthorized") {
                echo "<div class='faq-item'><h4 class='text-bold text-light'>Vous ne pouvez pas acceder a cette page. </h4></div>";
            }
        }
        echo ('<div>');
        ?>
        <div id="form"></div>
        <div id="error" class="text-light faq-item"></div>

        <!-- <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px"> -->
        <script>
            //permet de d'afficher dynamiquement les informations de l'assuré
            function resetForm(idIsModif = "no") {
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("form").innerHTML = this.responseText;
                    }
                }
                xhttp.open("POST", "coord.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send("rstform=ok&idIsModif=" + idIsModif);
            }
            //permet d'afficher les mots de passe en mode text
            function showPassword() {
                var passValue = [];
                passValue[0] = document.getElementById("oldPassword");
                passValue[1] = document.getElementById("newPassword");
                passValue[2] = document.getElementById("confirmNewPassword");
                for (let i = 0; i < passValue.length; i++) {
                    if (passValue[i].type === "password") {
                        passValue[i].type = "text";
                    } else {
                        passValue[i].type = "password";
                    }
                }
            }
            //permet de modifier l'identifiant de la session
            function editLogin() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById("login").value != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            resetForm("login");
                        }
                    }
                    xhttp.open("POST", "coord.php", true);
                    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhttp.send("newLogin=" + document.getElementById("login").value);
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur le champ est vide </h4></div>";
                    resetForm();
                }
            }
            //permet de modifier le mot de passe de la session
            function editPassword() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById("oldPassword").value != "" && document.getElementById("newPassword").value != "" && document.getElementById("confirmNewPassword").value != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("error").innerHTML = this.responseText;
                            if (document.getElementById("error").innerHTML == "") {
                                resetForm("password");
                            } else {
                                resetForm();
                            }
                        }
                    }
                    xhttp.open("POST", "coord.php", true);
                    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhttp.send("oldPassword=" + document.getElementById("oldPassword").value + "&newPassword=" + document.getElementById("newPassword").value + "&confirmNewPassword=" + document.getElementById("confirmNewPassword").value);
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur au moins un des champs est vide </h4></div>";
                    resetForm();
                }
            }
            //verifie que tout les caractères d'une chaine sont numériques
            function isNumeric(nb) {
                for (let i = 0; i < nb.length; i++) {
                    if (isNaN(nb.split("")[i])) {
                        return (false);
                    }
                }
                return (true);
            }
            //permet de modifier le numéro de téléphone de l'assuré
            function editPhoneNumber() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById("phoneNumber").value != "") {
                    var phoneNumber = document.getElementById("phoneNumber").value;
                    var phoneNumberTmp = "";
                    if (phoneNumber.split(' ').length > 1) {
                        for (let i = 0; i < phoneNumber.split(' ').length; i++) {
                            phoneNumberTmp += phoneNumber.split(' ')[i];
                        }
                        phoneNumber = phoneNumberTmp;
                    }
                    if (phoneNumber.length == 10 && isNumeric(phoneNumber)) {
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("error").innerHTML = this.responseText;
                                resetForm("phone");
                            }
                        }
                        xhttp.open("POST", "coord.php", true);
                        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhttp.send("newPhoneNumber=" + phoneNumber);
                    } else {
                        if (phoneNumber.length != 10) {
                            document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le format du nouveau numéro n'est pas valide. (bon format : 0000000000 ou 00 00 00 00 00) </h4></div>";
                            resetForm();
                        } else {
                            document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le numéro saisi n'est pas valide. </h4></div>";
                            resetForm();
                        }
                    }
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le champ est vide. </h4></div>";
                    resetForm();
                }
            }

            function editMail() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById("mail").value != "") {
                    var mail = document.getElementById("mail").value;
                    if (mail.split('@').length > 1) {
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("error").innerHTML = this.responseText;
                                resetForm("mail");
                            }
                        }
                        xhttp.open("POST", "coord.php", true);
                        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhttp.send("newMail=" + mail);
                    } else {
                        document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le mail saisi n'est pas valide. </h4></div>";
                        resetForm();
                    }
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le champ est vide. </h4></div>";
                    resetForm();
                }
            }

            function changeAdress() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById("adress").value != "" && document.getElementById("city").value != "" && document.getElementById("postalCode").value != "" && document.getElementById("country").value != "" && document.getElementById('proofAdress').files[0] != null) {
                    var postalCode = document.getElementById("postalCode").value;
                    var postalCodeTmp = "";
                    if (postalCode.split(' ').length > 1) {
                        for (let i = 0; i < postalCode.split(' ').length; i++) {
                            postalCodeTmp += postalCode.split(' ')[i];
                        }
                        postalCode = postalCodeTmp;
                    }
                    if (postalCode.length == 5 && isNumeric(postalCode)) {
                        var formData = new FormData();
                        formData.append("newAdress", document.getElementById("adress").value);
                        formData.append("newCity", document.getElementById("city").value);
                        formData.append("newCountry", document.getElementById("country").value);
                        formData.append("newPostalCode", document.getElementById("postalCode").value);
                        formData.append("proofAdress", document.getElementById('proofAdress').files[0], "file_name");
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("error").innerHTML = this.responseText;
                                resetForm("adress");
                            }
                        }
                        xhttp.open("POST", "coord.php", true);
                        xhttp.send(formData);
                    } else {
                        document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le code postal saisi n'est pas valide. </h4></div>";
                        resetForm();
                    }
                } else if (document.getElementById('proofAdress').files[0] == null) {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, aucun fichier chargé. </h4></div>";
                    resetForm();
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, au moins un des champs est vide. </h4></div>";
                    resetForm();
                }
            }
        </script>
    </main>
    <footer class="page-footer bg-dark">

        <div class="bg-success">
            <div class="container">
                <div class="row py-4 d-flex align-items-center">

                    <div class="col-md-12 text-light text-center">
                        <a href="#"><i class="fab fa-facebook-f text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-twitter text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-google-plus-g text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-linkedin-in text-light white-text mr-4"> </i></a>
                        <a href="#"><i class="fab fa-instagram text-light white-text"> </i></a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container text-center text-light text-md-left mt-5">
            <div class="row">

                <div class="col-md-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">MultiplAssur'</h6>
                    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 125px; height: 2px">
                    <p class="mt-2">Nous sommes la pour vous aider</p>
                </div>

                <div class="col-md-3 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Contacts</h6>
                    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 75px; height: 2px">
                    <ul class="list-unstyled">
                        <li class="my-2"><i class="fas fa-home mr-3"></i> Paris 75800, avenue de la république</li>
                        <li class="my-2"><i class="fas fa-envelope mr-3"></i>multiplassur@gmail.com</li>
                        <li class="my-2"><i class="fas fa-phone mr-3"></i>06 95 48 62 15</li>
                        <li class="my-2"><i class="fas fa-print mr-3"></i>multiplassur@gmail.com</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-copyright text-light text-light white-text bg-dark text-center py-3">
            <p>&copy; Copyright
                <a href="#">@2021</a>
            </p>
            <p>Designed by Bertails, Darrigrand, Longuet, Maurer</p>
        </div>
    </footer>
</body>

</html>