<?php
require_once(dirname(__FILE__) . '/../config/regexp.php');

require_once(dirname(__FILE__) . '/../models/Patient.php');

// Initialisation du tableau d'erreurs
$errorsArray = array();
/*************************************/

//On ne controle que s'il y a des données envoyées 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // lastname
    // On verifie l'existance et on nettoie
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($lastname)){
        // On test la valeur
        $testRegex = preg_match(REGEXP_STR_NO_NUMBER,$lastname);

        if($testRegex == false){
            $errorsArray['lastname_error'] = 'Merci de choisir un nom valide';
        }
    }else{
        $errorsArray['lastname_error'] = 'Le champ est obligatoire';
    }

    // ***************************************************************

    // FIRSTNAME
    // On verifie l'existance et on nettoie
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($firstname)){
        // On test la valeur
        $testRegex = preg_match(REGEXP_STR_NO_NUMBER,$firstname);

        if($testRegex == false){
            $errorsArray['firstname_error'] = 'Le prénom n\'est pas valide';
        }
    }else{
        $errorsArray['firstname_error'] = 'Le champ est obligatoire';
    }


    // ***************************************************************

    // DATE D'ANNIVERSAIRE 
    // On verifie l'existance et on nettoie
    $birthdate = trim(filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($birthdate)){
        // On test la valeur
        $testRegex = preg_match(REGEXP_DATE,$birthdate);

        if($testRegex == false){
            $errorsArray['birthdate_error'] = 'Le date n\'est pas valide, le format attendu est JJ/MM/AAAA';
        }
    }else{
        $errorsArray['birthdate_error'] = 'Le champ est obligatoire';
    }

    // ***************************************************************

     // TELEPHONE
    // On verifie l'existance et on nettoie
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($phone)){
        // On test la valeur
        $testRegex = preg_match(REGEXP_PHONE,$phone);

        if($testRegex == false){
            $errorsArray['phone_error'] = 'Le numero n\'est pas valide, les séparateur sont - . /';
        }
    }

    // ***************************************************************
    
    // EMAIL
    // On verifie l'existance et on nettoie
    $mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL));

    //On test si le champ n'est pas vide
    if(!empty($mail)){
        // On test la valeur
        $testMail = filter_var($mail, FILTER_VALIDATE_EMAIL);

        if($testMail == false){
            $errorsArray['mail_error'] = 'Le mail n\'est pas valide';
        }
    }else{
        $errorsArray['mail_error'] = 'Le champ est obligatoire';
    }

    // ***************************************************************


    // Si il n'y a pas d'erreurs, on enregistre un nouveau patient.
    $patient = new Patient($lastname, $firstname, $birthdate, $phone, $mail);
    if(empty($errorsArray) ){
        $result = $patient->create();
        if($result===true){
            header('location: /controllers/list-patientCtrl.php?msgCode=1');
        } else {
            // Si l'enregistrement s'est mal passé, on affiche à nouveau le formulaire de création avec un message d'erreur.
            $msgCode = $result;
        }
    }

}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/patients/form-patient.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/