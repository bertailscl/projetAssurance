<!DOCTYPE html>
<html lang="fr">

<head>
    <title>MultiplAssur'</title>
    <meta charset="UTF-8">
    <meta name="description" content="MultiplAssur'">
    <meta name="author" content="Bertails Clément/Maurer Pierrick/Longuet Maxime/Darrigrand Fabien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-dark clean-navbar">
        <div class="container">
            <p class="navbar-brand logo text-light"><img src="../assets/img/tech/logo.png" class="mr-3" alt="logo" height="25%" width="25%"></p><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li><a id='link' class="nav-link text-light" href='newContract.php'>Nouveau Contrat</a></li>
                    <li><a id='link' class="nav-link text-light" href='insuranceMail.php'>Messagerie</a></li>
                    <li><a id='link' class="nav-link text-light" href='consultSinister.php'>Consulter Sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='consultSell.php'>Consulter ventes</a></li>
                    <li><a id='link' class="nav-link text-light" href='validateChangeCoord.php'>Changement coordonnées</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
        <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px">
        <?php
        //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
        session_start();
        if (isset($_SESSION["profile"])) {
            if ($_SESSION["profile"] != 'manager') {
                switch ($_SESSION["profile"]) {
                    case 'police':
                        header('Location: ../policeModule/policeHome.php?errorLogin=noAuthorized');
                        exit();
                        break;

                    case 'insured':
                        header('Location: ../insuredModule/insuredHome.php?errorLogin=noAuthorized');
                        exit();
                        break;

                    case 'admin':
                        header('Location: ../adminModule/adminHome.php?errorLogin=noAuthorized');
                        exit();
                        break;

                    default:
                        session_unset();
                        header('Location: ../visitorModule/connection.php?errorConnetion=notConnect');
                        exit();
                        break;
                }
            }
        } else {
            session_unset();
            header('Location: ../visitorModule/connection.php?errorConnetion=notConnect');
            exit();
        }
        ?>
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
        echo ('<div id="infoActualContract"');
        if (isset($_SESSION["validity"]) && isset($_SESSION["insurance"]) && isset($_SESSION["immatriculation"]) && isset($_SESSION["contrat"])) {
            echo ('<div class="faq-item"><h4 class="text-bold text-light">Le contrat scanné est le n°' . $_SESSION["contrat"] . '</h4></div>');
            echo (' <input id="seeContractBtn" type="button" name="seeContract" value="Consulter le contrat flashé" onclick="seeContract()"><br><br>');
        } else {
            echo "<div class='faq-item'><h4 class='text-bold text-light'>Aucun contrat scanné.</h4></div>";
        }
        echo ('</div>');
        ?>
        <div id="displayContract">
        </div>
        <div id="contractsList">
            <label class="text-light" for="fname">Nom : </label>
            <input id="fname" name="fname" type="text" placeholder="Nom de l'assuré" required><br>
            <label class="text-light" for="name">Prénom : </label>
            <input id="name" name="name" type="text" placeholder="Prénom de l'assuré" required><br><br>
            <label class="text-light" for="contract">Contrat n°</label>
            <input id="contract" name="contract" oninput="this.value = this.value.toUpperCase()" type="text" placeholder="Numéro du contrat" required><br><br>
            <label class="text-light" for="phone">Numéro de téléphone : </label>
            <input id="phone" name="phone" type="text" placeholder="XXXXXXXXXX" required><br><br>
            <label class="text-light" for="mail">Adresse mail : </label>
            <input id="mail" name="mail" type="email" placeholder="exemple@exemple.ex" required><br><br>
            <input type="button" name="searchInsuredBtn" value="Rechercher un assuré" onclick="searchInsured()">
        </div>
        <div id="error" class="text-light faq-item"></div>
        <script>
            //verifie que tout les caractères d'une chaine sont numériques
            function isNumeric(nb) {
                for (let i = 0; i < nb.length; i++) {
                    if (isNaN(nb.split("")[i])) {
                        return (false);
                    }
                }
                return (true);
            }
            //requete ajax qui permet d'afficher le contrat scanné par le manager
            function seeContract() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById('seeContractBtn').value == "Masquer les informations") {
                    document.getElementById('seeContractBtn').value = "Consulter le contrat flashé";
                    document.getElementById('displayContract').innerHTML = "";
                } else {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("displayContract").innerHTML = this.responseText;
                            document.getElementById('seeContractBtn').value = "Masquer les informations";
                        }
                    }
                    xhttp.open("POST", "insuranceContract.php", true);
                    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhttp.send("scan=true");
                }
            }
            //requete ajax qui permet d'afficher un contrat choisi parmis la liste des contrats de l'assuré
            function showContract() {
                if (document.getElementById("contracts").value != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("displayContract").innerHTML = this.responseText;
                        }
                    }
                    xhttp.open("POST", "insuranceContract.php", true);
                    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhttp.send("contractList=true&immatriculation=" + document.getElementById("contracts").value);
                }
            }
            //permet d'afficher la carte verte du contrat affiché
            function showGreenCard() {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById("showGreenCardButton").value == "Afficher la carte verte") {
                    document.getElementById("showGreenCard").style = "display: inherit;";
                    document.getElementById("showGreenCardButton").value = "Masquer la carte verte";
                } else {
                    document.getElementById("showGreenCard").style = "display: none;";
                    document.getElementById("showGreenCardButton").value = "Afficher la carte verte";
                }
            }
            //permet d'afficher le form de modification du contrat
            function modifContract(immatriculation) {
                document.getElementById("error").innerHTML = "";
                if (document.getElementById('seeContractBtn') != null && document.getElementById('seeContractBtn').value == "Masquer les informations") {
                    document.getElementById('seeContractBtn').value = "Consulter le contrat flashé";
                    document.getElementById('displayContract').innerHTML = "";
                }
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("displayContract").innerHTML = this.responseText;
                    }
                }
                xhttp.open("POST", "insuranceContract.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send("form=true&immatriculation=" + immatriculation);
            }
            //permet de modifier le contrat
            function sendModifContract(immatriculation) {
                document.getElementById("error").innerHTML = "";
                var formData = new FormData();
                formData = checkDate(immatriculation);
                if (formData.get("sendChange") == "true") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("displayContract").innerHTML = this.responseText;
                        }
                    }
                    xhttp.open("POST", "insuranceContract.php", true);
                    xhttp.send(formData);
                } else if (formData.get("sendChange") != null && formData.get("sendChange") == "passed") {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, la date choisie est passée.</h4></div>";
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, la date choisie n'est pas valide.</h4></div>";
                }
            }
            //permet de verifier la date entrée par l'utilisateur
            function checkDate(immatriculation) {
                // var date = new Date();
                var formData = new FormData();
                var date = document.getElementById('newValidityStart').value;
                if (date != "" && date.split("-")[2] != null) {
                    var today = new Date();
                    today.getDate();
                    var dd = today.getDate();
                    var mm = today.getMonth() + 1;
                    var yyyy = today.getFullYear();
                    if (dd < 10) {
                        dd = '0' + dd
                    }
                    if (mm < 10) {
                        mm = '0' + mm
                    }
                    var dateStart = new Date();
                    var dateEnd = new Date();
                    if (date.split("-")[0] > yyyy || date.split("-")[0] <= yyyy && date.split("-")[1] > mm || date.split("-")[0] <= yyyy && date.split("-")[1] <= mm && date.split("-")[2] >= dd) {
                        d = date.split("-")[2];
                        m = date.split("-")[1];
                        y = parseInt(date.split("-")[0]) + 1;
                        formData.append("sendChange", true);
                        formData.append("immatriculation", immatriculation);
                        formData.append("newValidityStart", d + "/" + m + "/" + date.split("-")[0]);
                        formData.append("newValidityEnd", d + "/" + m + "/" + y);
                    } else {
                        formData.append("sendChange", "passed");
                    }
                    return formData;
                } else {
                    formData.append("sendChange", false);
                    return formData;
                }
            }
            //permet de chercher un assuré
            function searchInsured() {
                var formData = new FormData();
                document.getElementById("error").innerHTML = "";
                if (document.getElementById('name').value != "" && document.getElementById('fname').value != "") {
                    formData.append("name", document.getElementById('name').value);
                    formData.append("fname", document.getElementById('fname').value);
                    document.getElementById('name').value = "";
                    document.getElementById('fname').value = "";
                } else if (document.getElementById('contract').value != "") {
                    formData.append("contract", document.getElementById('contract').value);
                    document.getElementById('contract').value = "";
                } else if (document.getElementById('phone').value != "") {
                    var phoneNumber = document.getElementById("phone").value;
                    var phoneNumberTmp = "";
                    if (phoneNumber.split(' ').length > 1) {
                        for (let i = 0; i < phoneNumber.split(' ').length; i++) {
                            phoneNumberTmp += phoneNumber.split(' ')[i];
                        }
                        phoneNumber = phoneNumberTmp;
                    }
                    if (phoneNumber.length == 10 && isNumeric(phoneNumber)) {
                        formData.append("phone", phoneNumber);
                        document.getElementById('phone').value = "";
                    } else {
                        document.getElementById("phone").value = "";
                        if (phoneNumber.length != 10) {
                            document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le format du nouveau numéro n'est pas valide. (bon format : 0000000000 ou 00 00 00 00 00). </h4></div>";
                            return false;
                        } else {
                            document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le numéro saisi n'est pas valide.</h4></div>";
                            return false;
                        }
                    }
                } else if (document.getElementById('mail').value != "") {
                    formData.append("mail", document.getElementById('mail').value);
                    var mail = document.getElementById("mail").value;
                    if (mail.split('@').length > 1) {
                        formData.append("mail", document.getElementById('mail').value);
                        document.getElementById('mail').value = "";
                    } else {
                        document.getElementById("mail").value = "";
                        document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, le mail saisi n'est pas valide.</h4></div>";
                        return false;
                    }
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, aucun des champs n'est rempli.</h4></div>";
                    return false;
                }
                document.getElementById("displayContract").innerHTML = "";
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("error").innerHTML = this.responseText;
                        if (document.getElementById("error").innerHTML == "") {
                            var formData2 = new FormData();
                            formData2.append("printInsured", "true");
                            if (formData.has('name')) {
                                formData2.append('name2', formData.get('name'));
                                formData2.append('fname2', formData.get('fname'));
                            } else if (formData.has('contract')) {
                                formData2.append('contract2', formData.get('contract'));
                            } else if (formData.has('phone')) {
                                formData2.append('phone2', formData.get('phone'));
                            } else if (formData.has('mail')) {
                                formData2.append('mail2', formData.get('mail'));
                            }
                            xhttp2 = new XMLHttpRequest();
                            xhttp2.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("infoActualContract").innerHTML = this.responseText;
                                }
                            }
                            xhttp2.open("POST", "insuranceContract.php", true);
                            xhttp2.send(formData2);
                        }
                    }
                }
                xhttp.open("POST", "insuranceContract.php", true);
                xhttp.send(formData);
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