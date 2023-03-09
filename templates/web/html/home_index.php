<main>
  <header>
    <div class="stripe">
      <h2>Krypton General Bureaucracy</h2>
      <p class="connexion"><a href="/admin">Connexion</a></p>
    </div>
    <div>
      <img src="/assets/imgs/logoKGB.png" alt="" width="450">
    </div>
  </header>

  <div>
    <div class="stripe">
      <h2>Classified Missions</h2>
    </div>
    <div class="sorting">
      <input type="search" name="search-mission" id="search-mission" placeholder="Entrez le nom de code de la mission">
      <select id="status" name="status" class="" aria-label="" required>
        <option value="0" selected>Sélectionner un statut de mission</option>
        <?php 
          foreach($parameters['missions_status'] as $status) {
            ?>
            <option 
              value="<?= $status['row_id']?>"
            ><?= $status['label'] ?></option>
            <?php
          }
        ?>
      </select>
      <select id="type" name="type" class="" aria-label="" required>
        <option value="0" selected>Sélectionner un type de mission</option>
        <?php 
          foreach($parameters['missions_types'] as $type) {
            ?>
            <option 
              value="<?= $type['row_id']?>"
            ><?= $type['spe_name'] ?></option>
            <?php
          }
        ?>
      </select>
    </div>
  </div>

  <div id="mission-result">
  <?php
  foreach($parameters['missions'] as $mission) {
    ?>
      <div class="mission">
        <p class="code"><?= $mission->getName_code() ?></p>
        <p class="status"><?= $parameters['missions_status'][$mission->getStatus()-1]['label'] ?></p>
        <div class="mission-body">
          <p class="country"><span class="label">Pays concerné : </span><?= $parameters['missions_country'][$mission->getCountry()-1]['noun'] ?></p>
          <p class="type"><span class="label">Type de mission : </span><?= $parameters['missions_types'][$mission->getType()-1]['spe_name'] ?></p>
          <p class="description"><?= $mission->getDescription() ?></p>
        </div>
        <p class="link-mission"><a href="?mission=<?= $mission->getID() ?>">Voir la mission</a></p>
      </div>
    <?php
  }
  ?>
  </div>

  <footer>
    <div class="stripe">
      <p>Toutes les données affichées sont générées aléatoirement ou créer par un administrateur de manière arbitraire 
        et ont un but purement éducatif.</p>
    </div>

  </footer>
</main>


