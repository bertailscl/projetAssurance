<?php
    session_start();
    if(isset($_SESSION["profile"])){
        switch ($_SESSION["profile"]) {
            case 'admin':
                header('Location: ../adminModule/adminHome.php');
                exit();
                break;
            
            case 'manager':
                if (!isset($_POST['disaster']) && !isset($_POST['changeCoord'])) {
                    header('Location: insuredHome.php');
                    exit(); 
                }
                break;

            case 'police':
                header('Location: ../policeModule/policeHome.php');
                exit();
                break;
            
            case 'insured':
                header('Location: ../managerModule/managerHome.php');
                exit();
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
    //requete ajax permetant de valider le sinistre
    if (isset($_POST['disaster'])) {
        if ($data = json_decode(file_get_contents('../data/disaster.json'), true)) {
            foreach ($data['disaster'] as $key => &$disaster) {
                if ($_POST['name'] == $disaster['insuredName'] && $_POST['fname'] == $disaster['insuredFname'] && $_POST['vehicle'] == $disaster['vehicle'] && $_POST['disasterDate'] == $disaster['disasterDate']) {
                    $disaster['validation'] = 'validate';
                }
            }
            file_put_contents('../data/disaster.json', json_encode($data, JSON_PRETTY_PRINT));
        }
        header('Location: consultSinister.php');
        exit();
    }
    //requete ajax permetant de valider le changement de coordonnées
    if (isset($_POST['changeCoord'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
            foreach ($data['insured'] as $key => &$insured) {
                if ($_POST['name'] == $insured['name'] && $_POST['fname'] == $insured['fname']) {
                    $insured['adress'] = $_POST['newAdress'];
                    $insured['city'] = $_POST['newCity'];
                    $insured['postalCode'] = $_POST['newPostalCode'];
                    $insured['country'] = $_POST['newCountry'];
                }
            }
            file_put_contents('../data/insured.json', json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($myJson = json_decode(file_get_contents('../data/changeCoord.json'),true)) {
            foreach($myJson['changeCoord'] as $key => &$coord){
                if ($coord['insuredName'] == $_POST['name'] && $coord['insuredFname'] == $_POST['fname']) {
                    unset($myJson['changeCoord'][$key]);
                }
            }
            file_put_contents('../data/changeCoord.json', json_encode($myJson, JSON_PRETTY_PRINT));
        }
        header('Location: validateChangeCoord.php');
        exit();
    }
?>