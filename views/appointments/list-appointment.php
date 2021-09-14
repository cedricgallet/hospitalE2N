<!-- Affichage d'un message d'erreur personnalisé -->
<?php 
if(!empty($msgCode) || $msgCode = trim(filter_input(INPUT_GET, 'msgCode', FILTER_SANITIZE_STRING))) {
    if(!array_key_exists($msgCode, $displayMsg)){
        $msgCode = 0;
    }
    echo '<div class="alert '.$displayMsg[$msgCode]['type'].'">'.$displayMsg[$msgCode]['msg'].'</div>';
} ?>
<!-- -------------------------------------------- -->

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Date</th>
      <th scope="col">Heure</th>
      <th scope="col">Nom Prénom</th>
      <th scope="col">Phone</th>
      <th scope="col">Visualiser</th>
      <th scope="col">Supprimer</th>
    </tr>
  </thead>
  <tbody>

    <?php 
    $i=0;
    foreach($allAppointments as $appointment) {
        $i++;
        ?>
        <tr>
        <th scope="row"><?=$i?></th>
        <td><?=date('d.m.Y', strtotime($appointment->dateHour))?></td>
        <td><?=date('H:i', strtotime($appointment->dateHour))?></td>
        <td><?=htmlentities($appointment->lastname)?> <?=htmlentities($appointment->firstname)?></td>
        <td><?=htmlentities($appointment->phone)?></td>
        <td><a href="/controllers/display-appointmentCtrl.php?id=<?=$appointment->id?>"><i class="far fa-edit"></i></a></td>
        <td><a href="/controllers/delete-appointmentCtrl.php?id=<?=$appointment->id?>"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    <?php } ?>

  </tbody>
</table>