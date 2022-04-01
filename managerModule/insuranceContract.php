<?php
    session_start();
    //permet de rediriger automatiquement une personne lorsque l'on arrive sur cette page par l'url.
    if(isset($_SESSION["profile"])){
        switch ($_SESSION["profile"]) {
            case 'admin':
                header('Location: ../adminModule/adminHome.php');
                exit();
                break;
            
            case 'insured':
                header('Location: ../insuredModule/insuredHome.php');
                exit();
                break;

            case 'police':
                header('Location: ../policeModule/policeHome.php');
                exit();
                break;
            
            case 'manager':
                if (!isset($_POST["scan"]) && !isset($_POST['form']) && !isset($_POST['name']) && !isset($_POST['contract']) && !isset($_POST['phone']) && !isset($_POST['mail']) && !isset($_POST["printInsured"]) && !isset($_POST["contractList"]) && !isset($_POST['sendChange'])) {
                    header('Location: managerHome.php');
                    exit(); 
                }
                break;
            
            default:
                session_unset();
                header('Location: ../visitorModule/connection.php');
                exit();
                break;
        }
    }else {
        session_unset();
        header('Location: ../visitorModule/connection.php');
        exit();
    }
    //permet 'afficher le contrat scanné
    if (isset($_POST["scan"])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($car["greenCard"]["insurerInfo"]["name"] == $_SESSION["company"] && $car['greenCard']['codes']['contractNumber'] == $_SESSION['contrat']) {
                        echo("<div class='text-light'>");
                            echo('<h2>Voici le contrat</h2>');
                            echo'<div id="infoContract">';
                                echo("<div>La voiture assurée est : ".$car['greyCard']['D_1']." ".$car['greyCard']['D_3']."</div>");
                                echo("<div>Immatriculée : ".$car['greyCard']['A']."</div>");
                                echo("<div>Vous avez ce contrat depuis le : ".$car['greenCard']['validityStart']."</div>");
                                echo("<div>La validité de ce contrat se finira le : ".$car['greenCard']['validityEnd']."</div");
                                
                                echo("<div>Conducteur/s principal/aux du vehicule : <br>" .$car['greenCard']['namesAndAdress']['name']." ".$car['greenCard']['namesAndAdress']['fname']."<br>");
                                echo($car['greenCard']['namesAndAdress']['adress']."<br>");
                                echo($car['greenCard']['namesAndAdress']['city']." ".$car['greenCard']['namesAndAdress']['postalCode']."<br>");
                                echo($car['greenCard']['namesAndAdress']['country']."</div>");
                            
                                echo("<div>Informations de l'assureur : <br>" .$car['greenCard']['insurerInfo']['name']."<br>");
                                echo($car['greenCard']['insurerInfo']['adress']."<br>");
                                echo($car['greenCard']['insurerInfo']['city']." ".$car['greenCard']['insurerInfo']['postalCode']."<br>");
                                echo($car['greenCard']['insurerInfo']['country']."<br>");
                                echo($car['greenCard']['insurerInfo']['phoneNumber']."</div>");
                                echo('<input id="showGreenCardButton" type="button" name="showGreenCardButton" value="Afficher la carte verte" onclick="showGreenCard()"><br><br>');
                                echo("<input id='modifContract' type='button' name='modifContract' value='Modifier ce contrat' onclick='modifContract(\"".$car['greyCard']['A']."\")'>");
                                echo'</div>';
                            echo'<div id="showGreenCard" style="display: none;">';
                                echo('<h1>Carte Verte</h1>');
                                echo('<div id="1_2">');
                                    echo ('<div id="1">');
                                        echo("<div>Carte Internationale d'assurance automobile.</div>");
                                    echo('</div>');
                                    echo ('<div id="2">');
                                        echo("<div>Emise avec l'autorisation du bureau central français.</div>");
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="3_4">');
                                    echo ('<div id="3">');
                                        echo("<div>Valable du " .$car['greenCard']['validityStart']);
                                        echo(' au '.$car['greenCard']['validityEnd']."</div>");
                                    echo('</div>');
                                    echo ('<div id="4">');
                                        echo("<div>Code Pays / Code Assureur / Numéro de contrat : " .$car['greenCard']['codes']['countryCode']." / ".$car['greenCard']['codes']['insurerCode']." / ".$car['greenCard']['codes']['contractNumber']."</div>");
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="5_6_7">');
                                    echo ('<div id="5">');
                                        echo("<div>Numéro d'immatriculation : " .$car['greenCard']['immatriculation']."</div>");
                                    echo('</div>');
                                    echo ('<div id="6">');
                                        echo("<div>Catégorie du véhicule : " .$car['greenCard']['vehicleCategory']."</div>");
                                    echo('</div>');
                                    echo ('<div id="7">');
                                        echo("<div>Marque du véhicule : " .$car['greenCard']['model']."</div>");
                                    echo('</div>');
                                echo('</div>');
                                echo ('<div id="8">');
                                    echo("<div>Validité territoriale : | ");
                                    $countriesValidity =  $car['greenCard']['countriesValidity'];
                                    foreach ($countriesValidity as $key => $code) {
                                        echo($code." | ");
                                    }
                                    echo('</div>');
                                echo('</div>');
                                echo ('<div id="9">');
                                    echo("<div>Nom et adresse du souscripteur de la police(ou de l'utilisateur du véhicule) : <br>" .$car['greenCard']['namesAndAdress']['name']." ".$car['greenCard']['namesAndAdress']['fname']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['adress']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['city']." ".$car['greenCard']['namesAndAdress']['postalCode']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['country']."</div>");
                                echo('</div>');
                                echo ('<div id="10">');
                                    echo("<div>Cette carte a été délivrée par : <br>" .$car['greenCard']['insurerInfo']['name']."<br>");
                                    echo($car['greenCard']['insurerInfo']['adress']."<br>");
                                    echo($car['greenCard']['insurerInfo']['city']." ".$car['greenCard']['insurerInfo']['postalCode']."<br>");
                                    echo($car['greenCard']['insurerInfo']['country']."<br>");
                                    echo($car['greenCard']['insurerInfo']['phoneNumber']."</div>");
                                echo('</div>');
                                echo('<div id="codeCategorieVehicle">');
                                    echo('<div><b>A.</b> Automobile ');
                                    echo('<b> B.</b> MOTOCYCLE ');
                                    echo('<b> C.</b> CAMION OU TRACTEUR ');
                                    echo('<b> D.</b> CYCLE A MOTEUR AUXILIAIRE ');
                                    echo('<b> E.</b> AUTOBUS ET AUTOCAR ');
                                    echo('<b> F.</b> REMORQUE ');
                                    echo('<b> G.</b> AUTRES</div>');
                                echo('</div>');
                            echo('</div>');
                        echo('<br>');
                    echo ("</div>");
                    } else {
                    echo ("<div class='text-light'>");
                        echo "<div>vous n'avez pas accès aux détails de ce contrat</div>";
                    echo ("</div>");
                    }
                }
            }
        }
    }
    //permet d'afficher le form de modification du contrat
    if (isset($_POST['form'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($car['greenCard']['immatriculation'] == $_POST['immatriculation']) {
                    echo ("<div class='text-light'>");
                        echo("Le contrat choisi est le n°".$car['greenCard']['codes']['contractNumber']."<br><br>");
                        echo("
                            <label for='newValidityStart'>Commencer une periode de validité (1 an) a partir du : </label><br><br>
                            <input id='newValidityStart' name='newValidityStart' type='date' required><br><br>
                            <input type='button' name='sendModifContract' value='Valider' onclick='sendModifContract(\"".$_POST['immatriculation']."\")'><br><br>
                        ");
                    echo ("</div>");
                    }
                }
            }
        }
    }
    //permet de modifier le contrat
    if (isset($_POST['sendChange'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => &$insured){
                $cars = $insured['car'];
                foreach($cars as $key2 => &$car) {
                    if ($car['greenCard']['immatriculation'] == $_POST['immatriculation']) {
                        $car['greenCard']['validityStart'] = $_POST['newValidityStart'];
                        $car['greenCard']['validityEnd'] = $_POST['newValidityEnd'];
                    }
                }
                $insured['car'] = $cars;
            }
            file_put_contents('../data/insured.json', json_encode($data, JSON_PRETTY_PRINT));
        }
    echo ("<div class='text-light'>");
        echo "Le contrat a bien été mis a jour.<br><br>";
    echo ("</div>");
    }
    //permer d'afficher les erreurs de saisie
    if(isset($_POST['name'])){
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($insured['name'] == $_POST['name'] && $insured['fname'] == $_POST['fname'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                        exit();
                    } else if ($_SESSION['company'] =! $car['greenCard']['insurerInfo']['name']) {
                        echo "<div><h4>Erreur, cet assuré n'est pas client chez vous.</h4></div>";
                    }
                }
            }
            echo "<div><h4>Erreur, les informations fournies ne sont pas correctes.</h4></div>";
        }
    } 
    if(isset($_POST['contract'])){
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($car['greenCard']['codes']['contractNumber'] == $_POST['contract'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                        exit();
                    } else if ($_SESSION['company'] =! $car['greenCard']['insurerInfo']['name']) {
                        echo "<div><h4>Erreur, cet assuré n'est pas client chez vous.</h4></div>";
                    }
                }
            }
            echo "<div><h4>Erreur, le numéro de contrat n'existe pas.</h4></div>";
        }
    }
    if(isset($_POST['phone'])){
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($insured['phoneNumber'] == $_POST['phone'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                        exit();
                    } else if ($_SESSION['company'] =! $car['greenCard']['insurerInfo']['name']) {
                        echo "<div><h4>Erreur, cet assuré n'est pas client chez vous.</h4></div>";
                    }
                }
            }
            echo "<div><h4>Erreur, le numéro de téléphone fourni n'est pas enregistré.</h4></div>";
        }
    }
    if(isset($_POST['mail'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($insured['mail'] == $_POST['mail'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                        exit();
                    } else if ($_SESSION['company'] =! $car['greenCard']['insurerInfo']['name']) {
                        echo "<div><h4>Erreur, cet assuré n'est pas client chez vous.</h4></div>";
                    }
                }
            }
            echo "<div><h4>Erreur, le mail fourni n'est pas enregistré.</h4></div>";
        }
    }
    //afficher l'assuré trouvé
    if (isset($_POST["printInsured"])) {
        if(isset($_POST['name2'])){
            if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
                foreach($data['insured'] as $key => $insured){
                    $cars = $insured['car'];
                    foreach($cars as $key => $car) {
                        if ($insured['name'] == $_POST['name2'] && $insured['fname'] == $_POST['fname2']){
                        echo ("<div class='text-light'>");
                            echo ("<div>L'assuré trouvé est le suivant : </div>");
                            echo ("<div>Nom : ".$insured['name']."</div>");
                            echo ("<div>Prénom : ".$insured['fname']."</div>");
                            echo ("<div>Tel : ".$insured['phoneNumber']."</div>");
                            echo ("<div>Mail : ".$insured['mail']."</div>");
                            echo ("<div>Adresse : ".$insured['adress']."</div>");
                            echo ("<div>Ville : ".$insured['city']." ".$insured['postalCode']."</div>");
                            echo ("<div>Pays : ".$insured['country']."</div>");
                            echo "<label for='contracts'>Les contrats de l'assuré : </label>";
                            echo '<select id="contracts" name="contracts" required>';
                            echo "<option value='' disabled selected hidden>Les contrats</option>";
                            if ($insured['name'] == $_POST['name2'] && $insured['fname'] == $_POST['fname2'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                                echo "<option id='".$car['greyCard']['A']."' value='".$car['greyCard']['A']."'>".$car['greyCard']['D_1']." ".$car['greyCard']['D_3']." ".$car['greyCard']['A']."</option>";
                            }
                            echo ('</select>');
                            echo (' <input id="listSearchContract" class="button" type="button" name="listSearchContract" value="Afficher le contrat" onclick="showContract()"><br><br>');
                        echo ("</div>");
                        }
                    }
                }
            }
        }
        if(isset($_POST['contract2'])){
            if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
                foreach($data['insured'] as $key => $insured){
                    $cars = $insured['car'];
                    foreach($cars as $key => $car) {
                        if ($car['greenCard']['codes']['contractNumber'] == $_POST['contract2']){
                        echo ("<div class='text-light'>");
                            echo ("<div>L'assuré trouvé est le suivant : </div>");
                            echo ("<div>Nom : ".$insured['name']."</div>");
                            echo ("<div>Prénom : ".$insured['fname']."</div>");
                            echo ("<div>Tel : ".$insured['phoneNumber']."</div>");
                            echo ("<div>Mail : ".$insured['mail']."</div>");
                            echo ("<div>Adresse : ".$insured['adress']."</div>");
                            echo ("<div>Ville : ".$insured['city']." ".$insured['postalCode']."</div>");
                            echo ("<div>Pays : ".$insured['country']."</div>");
                            echo "<label for='contracts'>Les contrats de l'assuré : </label>";
                            echo '<select id="contracts" name="contracts" required>';
                            echo "<option value='' disabled selected hidden>Les contrats</option>";
                            if ($car['greenCard']['codes']['contractNumber'] == $_POST['contract2'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                                echo "<option id='".$car['greyCard']['A']."' value='".$car['greyCard']['A']."'>".$car['greyCard']['D_1']." ".$car['greyCard']['D_3']." ".$car['greyCard']['A']."</option>";
                            }
                            echo ('</select>');
                            echo (' <input id="listSearchContract" class="button" type="button" name="listSearchContract" value="Afficher le contrat" onclick="showContract()"><br><br>');
                        echo ("</div>");
                        }
                    }
                }
            }
        }
        if(isset($_POST['phone2'])){
            if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
                foreach($data['insured'] as $key => $insured){
                    $cars = $insured['car'];
                    foreach($cars as $key => $car) {
                        if ($insured['phoneNumber'] == $_POST['phone2']){
                        echo ("<div class='text-light'>");
                            echo ("<div>L'assuré trouvé est le suivant : </div>");
                            echo ("<div>Nom : ".$insured['name']."</div>");
                            echo ("<div>Prénom : ".$insured['fname']."</div>");
                            echo ("<div>Tel : ".$insured['phoneNumber']."</div>");
                            echo ("<div>Mail : ".$insured['mail']."</div>");
                            echo ("<div>Adresse : ".$insured['adress']."</div>");
                            echo ("<div>Ville : ".$insured['city']." ".$insured['postalCode']."</div>");
                            echo ("<div>Pays : ".$insured['country']."</div>");
                            echo "<label for='contracts'>Les contrats de l'assuré : </label>";
                            echo '<select id="contracts" name="contracts" required>';
                            echo "<option value='' disabled selected hidden>Les contrats</option>";
                            if ($insured['phoneNumber'] == $_POST['phone2'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                                echo "<option id='".$car['greyCard']['A']."' value='".$car['greyCard']['A']."'>".$car['greyCard']['D_1']." ".$car['greyCard']['D_3']." ".$car['greyCard']['A']."</option>";
                            }
                            echo ('</select>');
                            echo (' <input id="listSearchContract" class="button" type="button" name="listSearchContract" value="Afficher le contrat" onclick="showContract()"><br><br>');
                        echo ("</div>");
                        }
                    }
                }
            }
        }
        if(isset($_POST['mail2'])){
            if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
                foreach($data['insured'] as $key => $insured){
                    $cars = $insured['car'];
                    foreach($cars as $key => $car) {
                        if ($insured['mail'] == $_POST['mail2']){
                        echo ("<div class='text-light'>");
                            echo ("<div>L'assuré trouvé est le suivant : </div>");
                            echo ("<div>Nom : ".$insured['name']."</div>");
                            echo ("<div>Prénom : ".$insured['fname']."</div>");
                            echo ("<div>Tel : ".$insured['phoneNumber']."</div>");
                            echo ("<div>Mail : ".$insured['mail']."</div>");
                            echo ("<div>Adresse : ".$insured['adress']."</div>");
                            echo ("<div>Ville : ".$insured['city']." ".$insured['postalCode']."</div>");
                            echo ("<div>Pays : ".$insured['country']."</div>");
                            echo "<label for='contracts'>Les contrats de l'assuré : </label>";
                            echo '<select id="contracts" name="contracts" required>';
                            echo "<option value='' disabled selected hidden>Les contrats</option>";
                            if ($insured['mail'] == $_POST['mail2'] && $_SESSION['company'] == $car['greenCard']['insurerInfo']['name']) {
                                echo "<option id='".$car['greyCard']['A']."' value='".$car['greyCard']['A']."'>".$car['greyCard']['D_1']." ".$car['greyCard']['D_3']." ".$car['greyCard']['A']."</option>";
                            }
                            echo ('</select>');
                            echo (' <input id="listSearchContract" class="button" type="button" name="listSearchContract" value="Afficher le contrat" onclick="showContract()"><br><br>');
                        echo ("</div>");
                        }
                    }
                }
            }
        }
    }
    //permet d'afficher le contrat choisi parmis la liste des contrats de l'assuré
    if (isset($_POST["contractList"])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
            foreach($data['insured'] as $key => $insured){
                $cars = $insured['car'];
                foreach($cars as $key => $car) {
                    if ($car['greenCard']['immatriculation'] == $_POST['immatriculation']) {
                    echo ("<div class='text-light'>");
                        echo("Le contrat choisi est le n°".$car['greenCard']['codes']['contractNumber']."<br>");
                            echo('<h2>Voici le contrat</h2>');
                            echo'<div id="infoContract">';
                            echo("<div>La voiture assurée est : ".$car['greyCard']['D_1']." ".$car['greyCard']['D_3']."</div>");
                            echo("<div>Immatriculée : ".$car['greyCard']['A']."</div>");
                            echo("<div>Vous avez ce contrat depuis le : ".$car['greenCard']['validityStart']."</div>");
                            echo("<div>La validité de ce contrat se finira le : ".$car['greenCard']['validityEnd']."</div>");
                            
                            echo("<div>Conducteur/s principal/aux du vehicule : <br>" .$car['greenCard']['namesAndAdress']['name']." ".$car['greenCard']['namesAndAdress']['fname']."<br>");
                            echo($car['greenCard']['namesAndAdress']['adress']."<br>");
                            echo($car['greenCard']['namesAndAdress']['city']." ".$car['greenCard']['namesAndAdress']['postalCode']."<br>");
                            echo($car['greenCard']['namesAndAdress']['country']."</div>");
                        
                            echo("<div>Informations de l'assureur : <br>" .$car['greenCard']['insurerInfo']['name']."<br>");
                            echo($car['greenCard']['insurerInfo']['adress']."<br>");
                            echo($car['greenCard']['insurerInfo']['city']." ".$car['greenCard']['insurerInfo']['postalCode']."<br>");
                            echo($car['greenCard']['insurerInfo']['country']."<br>");
                            echo($car['greenCard']['insurerInfo']['phoneNumber']."</div>");
                            echo('<input id="showGreenCardButton" class="button" type="button" name="showGreenCardButton" value="Afficher la carte verte" onclick="showGreenCard()"><br><br>');
                            echo("<input id='modifContract' type='button' name='modifContract' value='Modifier ce contrat' onclick='modifContract(\"".$car['greyCard']['A']."\")'>");
                            echo'</div>';
                            echo'<div id="showGreenCard" style="display: none;">';
                                echo('<h1>Carte Verte</h1>');
                                echo('<div id="1_2">');
                                    echo ('<div id="1">');
                                        echo("<div>Carte Internationale d'assurance automobile.</div>");
                                    echo('</div>');
                                    echo ('<div id="2">');
                                        echo("<div>Emise avec l'autorisation du bureau central français.</div>");
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="3_4">');
                                    echo ('<div id="3">');
                                        echo("<div>Valable du " .$car['greenCard']['validityStart']);
                                        echo(' au '.$car['greenCard']['validityEnd']."</div>");
                                    echo('</div>');
                                    echo ('<div id="4">');
                                        echo("<div>Code Pays / Code Assureur / Numéro de contrat : " .$car['greenCard']['codes']['countryCode']." / ".$car['greenCard']['codes']['insurerCode']." / ".$car['greenCard']['codes']['contractNumber']."</div>");
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="5_6_7">');
                                    echo ('<div id="5">');
                                        echo("<div>Numéro d'immatriculation : " .$car['greenCard']['immatriculation']."</div>");
                                    echo('</div>');
                                    echo ('<div id="6">');
                                        echo("<div>Catégorie du véhicule : " .$car['greenCard']['vehicleCategory']."</div>");
                                    echo('</div>');
                                    echo ('<div id="7">');
                                        echo("<div>Marque du véhicule : " .$car['greenCard']['model']."</div>");
                                    echo('</div>');
                                echo('</div>');
                                echo ('<div id="8">');
                                    echo("<div>Validité territoriale : | ");
                                    $countriesValidity =  $car['greenCard']['countriesValidity'];
                                    foreach ($countriesValidity as $key => $code) {
                                        echo($code." | ");
                                    }
                                    echo('</div>');
                                echo('</div>');
                                echo ('<div id="9">');
                                    echo("<div>Nom et adresse du souscripteur de la police(ou de l'utilisateur du véhicule) : <br>" .$car['greenCard']['namesAndAdress']['name']." ".$car['greenCard']['namesAndAdress']['fname']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['adress']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['city']." ".$car['greenCard']['namesAndAdress']['postalCode']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['country']."</div>");
                                echo('</div>');
                                echo ('<div id="10">');
                                    echo("<div>Cette carte a été délivrée par : <br>" .$car['greenCard']['insurerInfo']['name']."<br>");
                                    echo($car['greenCard']['insurerInfo']['adress']."<br>");
                                    echo($car['greenCard']['insurerInfo']['city']." ".$car['greenCard']['insurerInfo']['postalCode']."<br>");
                                    echo($car['greenCard']['insurerInfo']['country']."<br>");
                                    echo($car['greenCard']['insurerInfo']['phoneNumber']."</div>");
                                echo('</div>');
                                echo('<div id="codeCategorieVehicle">');
                                    echo('<div><b>A.</b> Automobile ');
                                    echo('<b> B.</b> MOTOCYCLE ');
                                    echo('<b> C.</b> CAMION OU TRACTEUR ');
                                    echo('<b> D.</b> CYCLE A MOTEUR AUXILIAIRE ');
                                    echo('<b> E.</b> AUTOBUS ET AUTOCAR ');
                                    echo('<b> F.</b> REMORQUE ');
                                    echo('<b> G.</b> AUTRES</div>');
                                echo('</div>');
                            echo('</div>');
                        echo('<br>');
                    echo ("</div>");
                    }
                }
            }
        }
    }
