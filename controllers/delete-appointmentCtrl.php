<?php
require_once(dirname(__FILE__) . '/../models/Appointment.php');

// Nettoyage de l'id du rendez-vouspassé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*********************************************************/

// Récupération du rendez-vous pour savoir de quel patient il s'agit dans le but de rediriger à la fin
$appointment = Appointment::get($id);
/*********************************************************/

// Si $appointment n'est pas un objet, c'est qu'il y a une erreur 
if(!is_object($appointment)){
    header('location: /controllers/list-appointmentCtrl.php?msgCode=8'); // Redirect si le rdv n'a pas été trouvé
}

$idPatient = $appointment->idPatients;
$code = Appointment::delete($id);

// On redirige vers la page du profil du patient avec un code pour le message
header('location: /controllers/display-patientCtrl.php?id='.$idPatient.'&msgCode='.$code);
/*************************************************************/