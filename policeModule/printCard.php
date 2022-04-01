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
                if (!isset($_POST['card'])) {
                    header('Location: policeHome.php');
                    exit();
                }
                break;

            case 'manager':
                header('Location: ../managerModule/managerHome.php');
                exit();
                break;
            
            default:
                session_unset();
                header('Location: ../visitorModule/connection.php');
                exit();
                break;
        }
    } else {
        session_unset();
        header('Location: ../visitorModule/connection.php');
        exit();
    }

    if (isset($_POST["card"])) {
        //affiche la carte grise
        if ($_POST["card"] == 'greyCard') {
            if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
                foreach($data['insured'] as $key => $insured){
                    $cars = $insured['car'];
                    foreach($cars as $key => $car) {
                        if ($car['greyCard']['A'] == $_SESSION["immatriculation"]) {
                                echo('<h1>Carte Grise</h1>');
                                echo('<div id="AB>');
                                    echo ('<div id="A">');
                                        echo('<p>N°Immatriculation : <br>');
                                        echo('<b>A</b> : '.$car['greyCard']['A'].'</p>');
                                    echo('</div>');
                                    echo('<div="B">');
                                        echo('Date de 1ere immatriculation : <br>');
                                        echo('<b>B</b> : '.$car['greyCard']['B'].'<br>');
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="C">');
                                    echo('<p><b>C.1</b> : '.$car['greyCard']['C_1_name'].' '.$car['greyCard']['C_1_fname'].'</p>');
                                    echo('<p><b>C.3</b> : '.$car['greyCard']['C_3_adress'].'</p>');
                                    echo('             <p>'.$car['greyCard']['C_3_postal'].' '.$car['greyCard']['C_3_city'].' '.$car['greyCard']['C_3_country'].'</p>');
                                echo('</div>');
                                echo('<div id="D">');
                                    echo('<p><b>D.1</b> : '.$car['greyCard']['D_1'].' ');
                                    echo('<b>D.2</b> : '.$car['greyCard']['D_2'].' ');
                                    echo('<b>D.2.1</b> : '.$car['greyCard']['D_2_1'].' ');
                                    echo('<b>D.3</b> : '.$car['greyCard']['D_3'].'</p>');
                                echo('</div>');
                                echo('<div id="E">');
                                    echo('<p><b>E</b> : '.$car['greyCard']['E'].'</p>');
                                echo('</div>');
                                echo('<div id="F">');
                                    echo('<p><b>F.1</b> : '.$car['greyCard']['F_1'].' ');
                                    echo('<b>F.2</b> : '.$car['greyCard']['F_2'].' ');
                                    echo('<b>F.3</b> : '.$car['greyCard']['F_3'].'</p>');
                                echo('</div>');
                                echo('<div id="G">');
                                    echo('<p><b>G</b> : '.$car['greyCard']['G'].' ');
                                    echo('<b>G.1</b> : '.$car['greyCard']['G_1'].'</p>');
                                echo('</div>');
                                echo('<div id="J">');
                                    echo('<p><b>J</b> : '.$car['greyCard']['J'].' ');
                                    echo('<b>J.1</b> : '.$car['greyCard']['J_1'].' ');
                                    echo('<b>J.2</b> : '.$car['greyCard']['J_2'].' ');
                                    echo('<b>J.3</b> : '.$car['greyCard']['J_3'].'</p>');
                                echo('</div>');
                                echo('<div id="K">');
                                    echo('<p><b>K</b> : '.$car['greyCard']['K'].'</p>');
                                echo('</div>');
                                echo('<div id="P">');
                                    echo('<p><b>P.1</b> : '.$car['greyCard']['P_1'].' ');
                                    echo('<b>P.2</b> : '.$car['greyCard']['P_2'].' ');
                                    echo('<b>P.3</b> : '.$car['greyCard']['P_3'].' ');
                                    echo('<b>P.6</b> : '.$car['greyCard']['P_6'].'</p>');
                                echo('</div>');
                                echo('<div id="Q">');
                                    echo('<p><b>Q</b> : '.$car['greyCard']['Q'].'</p>');
                                echo('</div>');
                                echo('<div id="S">');
                                    echo('<p><b>S.1</b> : '.$car['greyCard']['S_1'].' ');
                                    echo('<b>S.2</b> : '.$car['greyCard']['S_2'].'</p>');
                                echo('</div>');
                                echo('<div id="U">');
                                    echo('<p><b>U.1</b> : '.$car['greyCard']['U_1'].' ');
                                    echo('<b>U.2</b> : '.$car['greyCard']['U_2'].'</p>');
                                echo('</div>');
                                echo('<div id="V">');
                                    echo('<p><b>V.7</b> : '.$car['greyCard']['V_7'].' ');
                                    echo('<b>V.9</b> : '.$car['greyCard']['V_9'].'</p>');
                                echo('</div>');
                                echo('<div id="X">');
                                    echo('<p><b>X.1</b> : '.$car['greyCard']['X_1'].'</p>');
                                echo('</div>');
                                echo('<div id="Y">');
                                    echo('<p><b>Y.1</b> : '.$car['greyCard']['Y_1'].' ');
                                    echo('<b>Y.2</b> : '.$car['greyCard']['Y_2'].' ');
                                    echo('<b>Y.3</b> : '.$car['greyCard']['Y_3'].' ');
                                    echo('<b>Y.4</b> : '.$car['greyCard']['Y_4'].' ');
                                    echo('<b>Y.5</b> : '.$car['greyCard']['Y_5'].' ');
                                    echo('<b>Y.6</b> : '.$car['greyCard']['Y_6'].'</p>');
                                echo('</div>');
                                echo('<div id="H">');
                                    echo('<p><b>H</b> : '.$car['greyCard']['H'].'</p>');
                                echo('</div>');
                                echo('<div id="I">');
                                    echo('<p><b>I</b> : '.$car['greyCard']['I'].'</p>');
                                echo('</div>');
                                echo('<div id="Z">');
                                    echo('<p><b>Z.1</b> : '.$car['greyCard']['Z_1'].' ');
                                    echo('<b>Z.2</b> : '.$car['greyCard']['Z_2'].' ');
                                    echo('<b>Z.3</b> : '.$car['greyCard']['Z_3'].' ');
                                    echo('<b>Z.4</b> : '.$car['greyCard']['Z_4'].'</p>');
                                echo('</div>');
                                echo('<div id="certificat">');
                                    echo("<p><b>Certificat d'immatriculation : </b></p>");
                                    echo('<p>'.$car['greyCard']['certificat']['immatriculation'].' '.$car['greyCard']['certificat']['immatriculationDate'].'</p>');
                                    echo('<p>'.$car['greyCard']['certificat']['code'].'</p>');
                                    echo('<p>'.$car['greyCard']['certificat']['cnit'].'</p>');
                                    echo('<p>'.$car['greyCard']['certificat']['brand'].'</p>');
                                    echo('<p>'.$car['greyCard']['certificat']['fname'].'</p>');
                                    echo('<p>'.$car['greyCard']['certificat']['name'].'</p>');
                                echo('</div>');
                        }
                    }
                }
            }
        }
        //affiche la carte verte
        if ($_POST["card"] == 'greenCard') {
            if ($data = json_decode(file_get_contents('../data/insured.json'),true)) {
                foreach($data['insured'] as $key => $insured){
                    $cars = $insured['car'];
                    foreach($cars as $key => $car) {
                        if ($car['greyCard']['A'] == $_SESSION["immatriculation"]) {
                                echo('<h1>Carte Verte</h1>');
                                echo('<div id="1_2">');
                                    echo ('<div id="1">');
                                        echo("<p>Carte Internationale d'assurance automobile.</p>");
                                    echo('</div>');
                                    echo ('<div id="2">');
                                        echo("<p>Emise avec l'autorisation du bureau central français.</p>");
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="3_4">');
                                    echo ('<div id="3">');
                                        echo("<p>Valable du " .$car['greenCard']['validityStart']);
                                        echo(' au '.$car['greenCard']['validityEnd']."</p>");
                                    echo('</div>');
                                    echo ('<div id="4">');
                                        echo("<p>Code Pays / Code Assureur / Numéro de contrat : " .$car['greenCard']['codes']['countryCode']." / ".$car['greenCard']['codes']['insurerCode']." / ".$car['greenCard']['codes']['contractNumber']."</p>");
                                    echo('</div>');
                                echo('</div>');
                                echo('<div id="5_6_7">');
                                    echo ('<div id="5">');
                                        echo("<p>Numéro d'immatriculation : " .$car['greenCard']['immatriculation']."</p>");
                                    echo('</div>');
                                    echo ('<div id="6">');
                                        echo("<p>Catégorie du véhicule : " .$car['greenCard']['vehicleCategory']."</p>");
                                    echo('</div>');
                                    echo ('<div id="7">');
                                        echo("<p>Marque du véhicule : " .$car['greenCard']['model']."</p>");
                                    echo('</div>');
                                echo('</div>');
                                echo ('<div id="8">');
                                    echo("<p>Validité territoriale : | ");
                                    for ($k=0; $k < sizeof($car['greenCard']['countriesValidity']); $k++) { 
                                        echo($car['greenCard']['countriesValidity'][$k]." | ");
                                    }
                                    echo('</p>');
                                echo('</div>');
                                echo ('<div id="9">');
                                    echo("<p>Nom et adresse du souscripteur de la police(ou de l'utilisateur du véhicule) : <br>" .$car['greenCard']['namesAndAdress']['name']." ".$car['greenCard']['namesAndAdress']['fname']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['adress']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['city']." ".$car['greenCard']['namesAndAdress']['postalCode']."<br>");
                                    echo($car['greenCard']['namesAndAdress']['country']."</p>");
                                echo('</div>');
                                echo ('<div id="10">');
                                    echo("<p>Cette carte a été délivrée par : <br>" .$car['greenCard']['insurerInfo']['name']."<br>");
                                    echo($car['greenCard']['insurerInfo']['adress']."<br>");
                                    echo($car['greenCard']['insurerInfo']['city']." ".$car['greenCard']['insurerInfo']['postalCode']."<br>");
                                    echo($car['greenCard']['insurerInfo']['country']."<br>");
                                    echo($car['greenCard']['insurerInfo']['phoneNumber']."</p>");
                                echo('</div>');
                                echo('<div id="codeCategorieVehicle">');
                                    echo('<p><b>A.</b> AUTOMOBILE ');
                                    echo('<b> B.</b> MOTOCYCLE ');
                                    echo('<b> C.</b> CAMION OU TRACTEUR ');
                                    echo('<b> D.</b> CYCLE A MOTEUR AUXILIAIRE ');
                                    echo('<b> E.</b> AUTOBUS ET AUTOCAR ');
                                    echo('<b> F.</b> REMORQUE ');
                                    echo('<b> G.</b> AUTRES</p>');
                                echo('</div>');
                        }
                    }
                }
            }
        }
    }
    
?>