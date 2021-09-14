<!-- Affichage d'un message d'erreur personnalisé -->
<?php 
if(!empty($msgCode) || $msgCode = trim(filter_input(INPUT_GET, 'msgCode', FILTER_SANITIZE_STRING))) {
    if(!array_key_exists($msgCode, $displayMsg)){
        $msgCode = 0;
    }
    echo '<div class="alert '.$displayMsg[$msgCode]['type'].'">'.$displayMsg[$msgCode]['msg'].'</div>';
} ?>
<!-- -------------------------------------------- -->

<div class="card">
  <div class="card-header">Rendez- vous de <strong><?=htmlentities($patient->firstname)?> <?=htmlentities($patient->lastname)?></strong></div>
  <div class="card-body">
    <h5 class="card-title"><?=htmlentities($appointment->dateHour)?></h5>
    <p class="card-text">
        <a href="mailto:<?=htmlentities($patient->mail)?>"><?=htmlentities($patient->mail)?></a> (<a href="tel:<?=htmlentities($patient->phone)?>"><?=htmlentities($patient->phone)?></a>)
    </p>
    <a href="/controllers/edit-appointmentCtrl.php?id=<?=$appointment->id?>" class="btn btn-primary">Modifier</a>
  </div>
</div>