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
                    <li><a id='link' class="nav-link text-light" href='sellVehicle.php'>Vente</a></li>
                    <li><a id='link' class="nav-link text-light" href='historyDisaster.php'> Historique sinistres</a></li>
                    <li><a id='link' class="nav-link text-light" href='insuredMail.php'></i> Messagerie</a></li>
                    <li><a id='link' class="nav-link text-light" href='../visitorModule/deconnection.php'><i class="fas fa-sign-out-alt mr-3"></i>Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page faq-page bg-dark">
    <hr class="bg-success mb-4 mt-0 d-inline-block mx-auto" style="width: 805px; height: 30px">
        <?php
        echo ('
                <section class="clean-block clean-faq">
                    <div class="container">
                        <div class="block-heading">
                            <h2 class="text-info">Bonjour ' . $_SESSION["login"] . '!</h2>
            ');
        echo "<div class='faq-item'><h4 class='text-bold text-light'>Veuillez remplir les champs ci-après pour faire votre déclaration de sinistre :</h4></div>";
        if (isset($_GET['errorLogin'])) {
            if ($_GET['errorLogin'] == "noAuthorized") {
                echo "<div class='faq-item'><h4 class='text-bold text-light'>Vous ne pouvez pas acceder a cette page. </h4></div>";
            }
        }
        echo '<div id="print">';
        if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
            foreach ($data['insured'] as $key => $insured) {
                if (isset($insured['name']) && isset($insured['fname'])) {
                    if ($_SESSION['name'] == $insured['name'] && $_SESSION['fname'] == $insured['fname']) {
                        echo ("<div class='text-light'>");
                        echo '<h3>Votre demande : </h3>';
                        echo '<form id="formNewContract">';
                        echo '<label for="disasterDate">Date du sinistre : </label>';
                        echo '<input name="disasterDate" id="disasterDate" type="date" value=""><br><br>';

                        echo '<label for="circonstances">Circonstances du sinistre : </label>';
                        echo '<input id="circonstances" name="circonstances" type="text" required><br><br>';
                        echo '<label for="proofDisaster">Choisissez une photo justifiant les dégâts matériels du sinistre: </label><br><br>';
                        echo '<input id="proofDisaster" name="proofDisaster" type="file" accept=".pdf, .png, .jpg, .jpeg" required><br><br>';

                        echo '<div id="carDamageForm">';
                        echo "<label for='myContracts'>Votre véhicule : </label>";
                        echo '<select id="myContracts" name="myContracts" required>';
                        echo "<option value='' disabled selected hidden>Mes véhicules</option>";
                        echo ("</div>");
                        $cars = $insured['car'];
                        if ($insured['name'] == $_SESSION["name"] && $insured['fname'] == $_SESSION["fname"]) {
                            foreach ($cars as $key => $car) {
                                echo "<option id=" . $car['greyCard']['A'] . " value=" . $car['greyCard']['A'] . ">" . $car['greyCard']['D_1'] . " " . $car['greyCard']['D_3'] . " " . $car['greyCard']['A'] . "</option>";
                            }
                        }
                        echo ("<div class='text-light'>");
                        echo '</select><br><br>
                                    <label for="damageNature">Nature des dommages : </label>
                                    <input id="damageNature" name="damageNature" type="text" required><br><br>
                                    <label for="nbOfInjured"> Le sinistre a-t-il occasioné des blessés ? : </label>
                                    <select id="nbOfInjured" name="nbOfInjured">
                                        <option value="aucun">Non</option>
                                        <option value="un">1 blessé</option>
                                        <option value="deux">2 blessés</option>
                                        <option value="trois">3 blessés</option>
                                        <option value="quatre">4 blessés</option>
                                        <option value="cinq">5 blessés</option>
                                    </select><br><br>
                                    <label for="garage">Nom et adresse du garagiste où le véhicule est (ou sera) visible : </label>
                                    <input id="garage" name="garage" type="text"><br><br>
                                    <label for="garageDate">A partir de : </label>
                                    <input id="garageDate" name="garageDate" type="date"><br><br>
                                    <label for="garagePhone">Numéro du garagiste : </label>
                                    <input id="garagePhone" name="garagePhone" type="text" pattern="[0-9]{10}"><br><br>
                                    </div>';

                        echo '<h3>Votre message :</h3>';
                        echo '<label for="message">Votre message : </label>';
                        echo '<input id="message" name="message" type="text"><br><br>';

                        echo '<h3>Vos coordonnées :</h3>';
                        echo '<label for="nom">Nom : </label>';
                        echo '<input id="nom" name="nom" type="text" value="' . $insured['name'] . '" required disabled><br><br>';
                        echo '<label for="fname">Prénom : </label>';
                        echo '<input id="fname" name="fname" type="text" value="' . $insured['fname'] . '" required disabled><br><br>';
                        echo '<label for="mail">Mail : </label>';
                        echo '<input id="mail" name="mail" type="email" placeHolder="myMail@example.com" value="' . $insured['mail'] . '" required disabled><br><br>';
                        echo '<label for="city">Ville : </label>';
                        echo '<input id="city" name="city" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['city'] . '" required disabled><br><br>';
                        echo '<label for="postalCode">Code postal : </label>';
                        echo '<input id="postalCode" name="postalCode" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['postalCode'] . '" required disabled><br><br>';
                        echo '<label for="country">Pays : </label>';
                        echo '<input id="country" name="country" type="text" oninput="this.value = this.value.toUpperCase()" value="' . $insured['country'] . '" required disabled><br><br>';
                        echo '<label for="constat">Ajoutez un constat si vous le souhaitez : </label><br><br>';
                        echo '<input id="constat" name="constat" type="file" accept=".pdf, .png, .jpg, .jpeg"><br><br>';
                        echo '<input id="validate" name="validate" type="button" onclick="sendData()" value="Valider">';
                        echo ("</div'>");
                        echo '</form>';
                    }
                }
            }
        }
        echo '</div>';
        ?>
        <div id="error" class="text-light faq-item"></div>
        <script>
            function getTodayDate() {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                var date = document.getElementById("disasterDate");
                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }
                today = yyyy + '-' + mm + '-' + dd;
                date.setAttribute("value", today);
            }
            getTodayDate();

            function sendData(){
                document.getElementById("error").innerHTML = "";
                var formData = new FormData(document.getElementById('formNewContract'));
                if (formData.get('disasterDate') != null && formData.get('circonstances') != null && formData.get('proofDisaster') != null && formData.get('myContracts') != null && formData.get('damageNature') != null && formData.get('nbOfInjured') != null && formData.get('garage') != null && formData.get('garageDate') != null && formData.get('garagePhone') != null && formData.get('message') != null && formData.get('constat') != null) {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("error").innerHTML = this.responseText;
                            if (document.getElementById("error").innerHTML == "") {
                                document.getElementById("error").innerHTML = "<h4>Le document a bien été envoyé.</h4";
                            }
                        }
                    }
                    xhttp.open("POST", "disaster.php", true);
                    xhttp.send(formData);
                } else {
                    document.getElementById("error").innerHTML = "<div class='faq-item'><h4 class='text-bold text-light'>Erreur, au moins un des champs est vide.</h4></div>";
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