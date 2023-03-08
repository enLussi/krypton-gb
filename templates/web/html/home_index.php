<?php
echo '<pre>';
// var_dump($parameters['missions']);
// var_dump($parameters['mission_types']);
echo '</pre>';

?>
<input type="search" name="search-mission" id="search-mission" placeholder="Entrez le titre ou le nom de code de la mission">
<div id="mission-result">
<?php
foreach($parameters['missions'] as $mission) {
  ?>
    <div class="mission">
      <p><a href="?mission=<?= $mission->getID() ?>"><?= $mission->getName_code() ?></a></p>
      <p><?= $mission->getStatus() ?></p>
      <p><?= $mission->getType() ?></p>
      <p><?= $mission->getCountry() ?></p>
    </div>
  <?php
}
?>
</div>


