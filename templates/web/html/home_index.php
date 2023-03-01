<?php
echo '<pre>';
// var_dump($parameters['missions']);
// var_dump($parameters['mission_types']);
echo '</pre>';

foreach($parameters['missions'] as $mission) {
  ?>
    <div class="mission">
      <p><a href="?mission=<?= $mission['row_id'] ?>"><?= $mission['name_code'] ?></a></p>
      <p><?= $mission['descript'] ?></p>
      <p><?= $parameters['missions_types'][$mission['mission_type_id']-1]['spe_name'] ?></p>
      <p><?= $parameters['missions_country'][$mission['country_id']-1]['noun'] ?></p>
    </div>
  <?php
}

?>



