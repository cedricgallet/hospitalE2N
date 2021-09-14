<?php
require_once(dirname(__FILE__) . '/../config/regexp.php');

require_once(dirname(__FILE__) . '/../models/Patient.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

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


    // DATE ET HEURE DE RDV
    // On verifie l'existance et on nettoie
    $dateHour = trim(filter_input(INPUT_POST, 'dateHour', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($dateHour)){
        // On test la valeur
        $testRegex = preg_match(REGEXP_DATE_HOUR,$dateHour);

        if($testRegex == false){
            $errorsArray['dateHour_error'] = 'Le date n\'est pas valide, le format attendu est JJ/MM/AAAA HH:mm';
        }
    }else{
        $errorsArray['dateHour_error'] = 'Le champ est obligatoire';
    }

    // ***************************************************************

    // Si il n'y a pas d'erreurs, on enregistre tout en une fois grâce aux transactions
    if(empty($errorsArray) ){
        $pdo = Database::getInstance();
        $pdo->beginTransaction();
        $patient = new Patient($lastname, $firstname, $birthdate, $phone, $mail);
        $createPatient = $patient->create();
        $idPatients = $pdo->lastInsertId();
        $appointment = new Appointment($dateHour,$idPatients);
        $createAppointment = $appointment->create();
        
        if($createPatient === true && $createAppointment === true){
            $pdo->commit(); // Valide la transaction et exécute toutes les requetes 
        } else {
            $pdo->rollBack(); // Annulation de toutes les requêtes exécutées avant la levée de l'exception
        }
    }
}


/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/add-patient-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/