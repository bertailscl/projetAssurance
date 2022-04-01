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
                    <li class="nav-item"><a class="nav-link text-light" href="../visitorModule/deconnection.php"><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
        <?php
        //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
        session_start();
        if (isset($_SESSION["profile"])) {
            if ($_SESSION["profile"] != 'police') {
                switch ($_SESSION["profile"]) {
                    case 'admin':
                        header('Location: ../adminModule/adminHome.php?errorLogin=noAuthorized');
                        exit();
                        break;

                    case 'insured':
                        header('Location: ../insuredModule/insuredHome.php?errorLogin=noAuthorized');
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
        // détermine si un qr code a été scanné et verifie la validité de la carte verte
        if (isset($_SESSION["validity"]) && isset($_SESSION["insurance"]) && isset($_SESSION["immatriculation"]) && isset($_SESSION["contrat"])) {
            if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
                foreach ($data['insured'] as $key => $insured) {
                    $cars = $insured['car'];
                    foreach ($cars as $key => $car) {
                        if ($car['greyCard']['A'] == $_SESSION["immatriculation"]) {
                            echo ('
                                    <div class=" block-content">
                                        <div id="validity">
                                            <input hidden id="validityEnd" name="validityEnd" type="text" value="' . $car['greenCard']['validityEnd'] . '">
                                        </div>
                                ');
                        }
                    }
                }
            }
            //bouttons permettant d'afficher la carte grise / verte.
            echo ("<div class='faq-item'><h4 class='text-bold text-dark'>Plus de détails : </h4></div>");
            echo ('<input class="btn btn-primary btn-block" type="button" name="greyCard" value="Carte grise" onclick="printGreyCard()">');
            echo ('<input class="btn btn-primary btn-block" type="button" name="greenCard" value="Carte verte" onclick="printGreenCard()">');
            echo ('<input id="maskCardBtn" style="display:none" class="btn btn-primary btn-block" type="button" name="maskCardBtn" value="Masquer la carte" onclick="maskCard()">');
        } else {
            echo ('<div class=" block-content">');
            echo ("<div class='faq-item'><h4 class='text-bold text-dark'>Aucun Code QR n'as été scanné, veuillez en scanner un.</h4></div>");
        }
        ?>
        </div>
        </div>
        <div id="afficherCard" style="display:none" class="container">
            <div class="block-heading">
                <div class=" block-content">
                    <div id="card"></div>
                </div>
            </div>
        </div>
        </section>
        <script>
            // ecrit un message en fonction de la validité de la carte verte
            if (document.getElementById("validity") != null) {
                var validity_date = document.getElementById("validityEnd").value;
                var today = new Date();
                var today_day = today.getDate();
                var today_month = today.getMonth() + 1
                if (today_month < 10) {
                    today_month = '0' + today_month;
                }
                var today_year = today.getFullYear();
                var current_date = today_day + '/' + today_month + '/' + today_year;
                document.getElementById('validity').innerHTML += "<div class='faq-item'><h4 class='text-bold text-dark'>Date d expiration de l'assurance : <span class='answer text-bold'>" + validity_date + "</span></h4></div>";
                document.getElementById('validity').innerHTML += "<div class='faq-item'><h4 class='text-bold text-dark'>Date du jour : <span class='answer text-bold'>" + current_date + "</span></h4></div>";
                if (validity_date.split("/")[2] < today_year || validity_date.split("/")[2] == today_year && validity_date.split("/")[1] < today_month || validity_date.split("/")[2] == today_year && validity_date.split("/")[1] == today_month && validity_date.split("/")[0] < today_day) {
                    document.getElementById('validity').innerHTML += "<div class='faq-item'><h4 class='text-bold text-dark'> La date de l'assurance est dépassée </h4></div>";
                } else {
                    document.getElementById('validity').innerHTML += "<div class='faq-item'><h4 class='text-bold text-dark'>L'assurance est valide</h4></div>";
                }
            }
            //permet d'afficher la carte grise du vehicule scanné
            function printGreyCard() {
                document.getElementById("card").innerHTML = "";
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("card").innerHTML = this.responseText;
                        document.getElementById("afficherCard").style.display = "inherit";
                        document.getElementById("maskCardBtn").style.display = "inherit";
                    }
                }
                xhttp.open("POST", "printCard.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send("card=greyCard");
            }
            //permet d'afficher la carte verte du vehicule scanné
            function printGreenCard() {
                document.getElementById("card").innerHTML = "";
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("card").innerHTML = this.responseText;
                        document.getElementById("afficherCard").style.display = "inherit";
                        document.getElementById("maskCardBtn").style.display = "inherit";
                    }
                }
                xhttp.open("POST", "printCard.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.send("card=greenCard");
            }
            //permet de masquer la carte
            function maskCard() {
                document.getElementById("afficherCard").style.display = "none";
                document.getElementById("maskCardBtn").style.display = "none";
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