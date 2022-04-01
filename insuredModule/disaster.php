<?php
    session_start();
    if(isset($_SESSION["profile"])){
        switch ($_SESSION["profile"]) {
            case 'admin':
                header('Location: ../adminModule/adminHome.php');
                exit();
                break;
            
            case 'insured':
                if (!isset($_POST['disasterDate'])) {
                    header('Location: insuredHome.php');
                    exit(); 
                }
                break;

            case 'police':
                header('Location: ../policeModule/policeHome.php');
                exit();
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
    }else {
        session_unset();
        header('Location: ../visitorModule/connection.php');
        exit();
    }

    if (isset($_POST['disasterDate'])) {
        if ($data = json_decode(file_get_contents('../data/insured.json'), true)) {
            foreach ($data['insured'] as $key => $insured) {
                if ($_SESSION['name'] == $insured['name'] && $_SESSION['fname'] == $insured['fname']) {
                    $cars = $insured['car'];
                    foreach ($cars as $key => $car) {
                        $newDisaster = array(
                            "insuredName" => $_SESSION["name"],
                            "insuredFname" => $_SESSION["fname"],
                            "insurance" => $car['greenCard']['insurerInfo']['name'],
                            "vehicle" => $_POST["myContracts"],
                            "disasterDate" => $_POST['disasterDate'],
                            "circonstances" => $_POST["circonstances"],
                            "damageNature" => $_POST["damageNature"],
                            "nbOfInjured" => $_POST["nbOfInjured"],
                            "garage" => $_POST["garage"],
                            "garageDispoDate" => $_POST["garageDate"],
                            "garagePhone" => $_POST["garagePhone"],
                            "message" => $_POST["message"],
                            "validation" => "notValidate"
                        );
                    }
                }
            }
        }
        if ($myJson = json_decode(file_get_contents('../data/disaster.json'),true)) {
            array_push($myJson['disaster'], $newDisaster);
            file_put_contents('../data/disaster.json', json_encode($myJson, JSON_PRETTY_PRINT));
        }
        $_FILES['proofDisaster'];
        switch ($_FILES["proofDisaster"]["type"]) {
            case "image/png":
                $path = '../data/proofsDisaster/'.$_POST["myContracts"].'.png';
                move_uploaded_file($_FILES["proofDisaster"]["tmp_name"], $path);
                break;

            case "image/jpg":
                $path = '../data/proofsDisaster/'.$_POST["myContracts"].'.jpg';
                move_uploaded_file($_FILES["proofDisaster"]["tmp_name"], $path);
                break;

            case "image/jpeg":
                $path = '../data/proofsDisaster/'.$_POST["myContracts"].'.jpeg';
                move_uploaded_file($_FILES["proofDisaster"]["tmp_name"], $path);
                break;

            case "application/pdf":
                $path = '../data/proofsDisaster/'.$_POST["myContracts"].'.pdf';
                move_uploaded_file($_FILES["proofDisaster"]["tmp_name"], $path);
                break;

            default:
                echo "<h4 class='faq-item'>Erreur, le fichier de preuve de sinistre n'a pas été saisi.</h4>";
                break;
        }
        switch ($_FILES["constat"]["type"]) {
            case "image/png":
                $path = '../data/constats/'.$_POST["myContracts"].'.png';
                move_uploaded_file($_FILES["constat"]["tmp_name"], $path);
                break;
    
            case "image/jpg":
                $path = '../data/constats/'.$_POST["myContracts"].'.jpg';
                move_uploaded_file($_FILES["constat"]["tmp_name"], $path);
                break;
    
            case "image/jpeg":
                $path = '../data/constats/'.$_POST["myContracts"].'.jpeg';
                move_uploaded_file($_FILES["constat"]["tmp_name"], $path);
                break;
    
            case "application/pdf":
                $path = '../data/constats/'.$_POST["myContracts"].'.pdf';
                move_uploaded_file($_FILES["constat"]["tmp_name"], $path);
                break;
    
            default:
                // echo "<h4 class='faq-item'>Erreur, le fichier de constat n'a pas été saisi.</h4>";
                break;
        }
    }
?>