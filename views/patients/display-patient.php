<div class="card">
  <div class="card-header"><?=htmlentities($patient->firstname)?> <?=htmlentities($patient->lastname)?></div>
  <div class="card-body">
    <h5 class="card-title"><?=htmlentities($patient->birthdate)?></h5>
    <p class="card-text">
        <?=htmlentities($patient->mail)?> (<?=htmlentities($patient->phone)?>)
    </p>
    <a href="/controllers/edit-patientCtrl.php?id=<?=htmlentities($patient->id)?>" class="btn btn-primary">Modifier</a>
  </div>
</div>
