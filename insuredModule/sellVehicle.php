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

<body>
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
                    <li><a id='link' class="nav-link text-light" href='changeCoord.php'>Coordonnées</a></li>
                    <li><a id='link' class="nav-link text-light" href='declareDisaster.php'>Déclarer sinistre</a></li>
                    <li><a id='link' class="nav-link text-light" href='historyDisaster.php'> Historique des sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='insuredMail.php'></i> Messagerie</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px">
    <main class="page faq-page bg-dark">

        <?php
        echo ('<br><br><br><br>');
        echo ('
                <section class="clean-block clean-faq">
                    <div class="container">
                        <div class="block-heading">
                            <h2 class="text-info ">Bonjour ' . $_SESSION["login"] . '!</h2>
            ');
        //affiche un message si l'assuré essaye d'atteindre une page dans laquelle il n'a pas les droits
        if (isset($_GET['errorLogin'])) {
            if ($_GET['errorLogin'] == "noAuthorized") {
                echo "<div class='faq-item'><h4 class='text-bold text-light'>Vous ne pouvez pas acceder a cette page. </h4></div>";
            }
        }
        echo ('<div>');
        ?>

        <div id="vehicleInfo">
            <form id="formSellVehicle">
                <div class='text-light'>
                    <section class="clean-block clean-form dark bg-dark">
                        <div class="container">
                            <label for='myContracts'>Veuillez sélectionnez le véhicule dont vous souhaitez faire la déclaration de cession : </label>
                            <select id="myContracts" name="myContracts" required>
                                <option value='' disabled selected hidden>Mes véhicules</option>
                                <?php
                                if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
                                    foreach ($data['insured'] as $key => $insured) {
                                        if (isset($insured['name']) && isset($insured['fname'])) {
                                            if ($_SESSION['name'] == $insured['name'] && $_SESSION['fname'] == $insured['fname']) {
                                                $cars = $insured['car'];
                                                if ($insured['name'] == $_SESSION["name"] && $insured['fname'] == $_SESSION["fname"]) {
                                                    foreach ($cars as $key => $car) {
                                                        echo "<option id=" . $car['greyCard']['A'] . " value=" . $car['greyCard']['A'] . ">" . $car['greyCard']['D_1'] . " " . $car['greyCard']['D_3'] . " " . $car['greyCard']['A'] . "</option>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select><br><br>
                            <label for="proofSell">Choisissez une photo de déclaration de cession de véhicule: </label><br><br>
                            <input id="proofSell" name="proofSell" type="file" accept=".pdf, .png, .jpg, .jpeg" required><br><br>
                            <input id="validate" name="validate" type="button" onclick="sendData()" value="Valider">
                        </div>
                    </section>
                </div>
            </form>
        </div>
        <div id="error" class="text-light faq-item"></div>
        <script>
            function sendData(){
                document.getElementById("error").innerHTML = "";
                var formData = new FormData(document.getElementById('formSellVehicle'));
                formData.append('endDate', newValidityEnd());
                if (formData.get('myContracts') != "" && formData.get('proofSell') != null) {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("error").innerHTML = this.responseText;
                            if (document.getElementById("error").innerHTML == "") {
                                document.getElementById("error").innerHTML = "<h4>Le document a bien été envoyé.</h4";
                            }
                        }
                    }
                    xhttp.open("POST", "sell.php", true);
                    xhttp.send(formData);
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, au moins un des champs est vide.</h4></div>";
                }
            }
            function newValidityEnd(){
                var today = new Date();
                today.setMonth(today.getMonth() + 1);
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd
                }
                if (mm < 10) {
                    mm = '0' + mm
                }
                return (dd + "/" + mm + "/" + yyyy);
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