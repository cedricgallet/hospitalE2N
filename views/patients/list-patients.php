<!-- Affichage d'un message d'erreur personnalisé -->
<?php 
if(!empty($msgCode) || $msgCode = trim(filter_input(INPUT_GET, 'msgCode', FILTER_SANITIZE_STRING))) {
    if(!array_key_exists($msgCode, $displayMsg)){
        $msgCode = 0;
    }
    echo '<div class="alert '.$displayMsg[$msgCode]['type'].'">'.$displayMsg[$msgCode]['msg'].'</div>';
} ?>
<!-- -------------------------------------------- -->

<form action="" method="GET">

  <input type="text" name="s" id="s" value="<?=$s?>">
  <input type="submit" value="Rechercher">

</form>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Prénom</th>
      <th scope="col">Nom</th>
      <th scope="col">Date de naissance</th>
      <th scope="col">Email</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

    <?php 
    $i=0;
    foreach($allPatients as $patient) {
        $i++;
        ?>
        <tr>
        <th scope="row"><?=htmlentities($patient->id)?></th>
        <td><?=htmlentities($patient->firstname)?></td>
        <td><?=htmlentities($patient->lastname)?></td>
        <td><?=htmlentities($patient->birthdate)?></td>
        <td><?=htmlentities($patient->mail)?></td>
        <td>
          <a href="/controllers/display-patientCtrl.php?id=<?=htmlentities($patient->id)?>"><i class="far fa-edit"></i></a>
          <a href="/controllers/delete-patientCtrl.php?id=<?=htmlentities($patient->id)?>"><i class="fas fa-trash-alt"></i></a>
        </td>
        </tr>
    <?php } ?>

  </tbody>
</table>

<nav aria-label="...">
  <ul class="pagination pagination-sm">
    

      <?php
      for($i=1;$i<=$nbPages;$i++){
        if($i==$currentPage){ ?>    
          <li class="page-item active" aria-current="page">
            <span class="page-link">
              <?=$i?> 
              <span class="visually-hidden">(current)</span>
            </span>
          </li>
    <?php } else { ?>
      <li class="page-item"><a class="page-link" href="?currentPage=<?=$i?>&s=<?=$s?>"><?=$i?></a></li>
    <?php } 
    }?>
  </ul>
</nav>