<?php
echo '<pre>';
// var_dump($parameters['missions']);
// var_dump($parameters['mission_types']);
echo '</pre>';


foreach($parameters['missions'] as $mission) {
  ?>
    <div class="mission">
      <p><a href="?mission=<?= $mission->getID() ?>"><?= $mission->getName_code() ?></a></p>
      <p><?= $mission->getDescription() ?></p>
      <p><?= $mission->getType() ?></p>
      <p><?= $mission->getCountry() ?></p>
    </div>
  <?php
}

?>



