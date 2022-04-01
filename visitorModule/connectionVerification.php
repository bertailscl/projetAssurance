<?php
    //verifier que le compte existe
    session_start();
    if ($data = json_decode(file_get_contents('../data/login.json'),true)) {
        foreach($data['registered'] as $key => $registered){
            if($registered['login'] == $_POST["login"] && password_verify($_POST["password"], $registered['password'])){
                $_SESSION["login"] = $registered['login'];
                $_SESSION["password"] = $registered["password"];
                $_SESSION["profile"] = $registered['profile'];
                switch ($_SESSION["profile"]) {
                    case 'police':
                        header('Location: ../policeModule/policeHome.php');
                        exit();
                        break;
                    
                    case 'insured':
                        $_SESSION["name"] = $registered['name'];
                        $_SESSION["fname"] = $registered['fname'];
                        header('Location: ../insuredModule/insuredHome.php');
                        exit();
                        break;

                    case 'manager':
                        $_SESSION["company"] = $registered['company'];
                        header('Location: ../managerModule/managerHome.php');
                        exit();
                        break;

                    case 'admin':
                        header('Location: ../adminModule/adminHome.php');
                        exit();
                        break;

                    default:
                        header('Location: connection.php?errorConnection=errorConnection');
                        exit();
                        break;
                }
            } 
        }
    }
    // revenir a la connexion en ecrivant une erreur si les informations ne sont pas bonnes
    header('Location: connection.php?errorConnection=errorConnection');
    exit();
?>