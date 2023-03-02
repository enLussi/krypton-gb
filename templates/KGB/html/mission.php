<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>

  <section>
    <!-- Liste des Missions avec un champs de recherche -->
  </section>
  <section>
    <h3 class="mb-5"></h3>
    <form action="" method="post" id="mission-prepare">

      <div class="mb-4 p-2 border border-1 rounded">

          <!-- string $title, string $description, string $name_code, int $country, array $agents, array $contacts, 
        array $targets, int $type, string $start_date, string $end_date -->

        <!-- Titre de la mission -->
        <div class="py-2 input-group">
          <span class="input-group-text">Titre de la mission</span>
          <input type="text" class="form-control" id="title-mission" name="title-mission" required value="">
        </div>
        <!-- Nom de code de la mission -->
        <div class="py-2 input-group">
          <span class="input-group-text">Nom de code</span>
          <input type="text" class="form-control" id="name_code" name="name_code" required value="">
        </div>
        <!-- Description de la mission -->
        <div class="py-2 input-group">
          <span class="input-group-text">Description de la mission</span>
          <textarea 
            class="form-control" 
            id="description-mission" 
            name="description-mission" 
            rows="2"
          >

          </textarea>
        </div>

        <select id="status" name="status" class="form-select" aria-label="">
          <option value="0" selected>Statut de la mission</option>
          <?php 
            foreach($parameters['status'] as $status) {
              ?>
              <option value="<?= $status['row_id']?>"><?= $status['label'] ?></option>
              <?php
            }
          ?>
        </select>

        <div class="mb-4 p-2 border border-1 rounded">
          <select id="country" name="country" class="form-select" aria-label="">
            <option value="0" selected>Pays concerné</option>
            <?php 
              foreach($parameters['country'] as $country) {
                ?>
                <option value="<?= $country['row_id']?>"><?= $country['noun'] ?></option>
                <?php
              }
            ?>
          </select>

          <div class="mb-4 p-2 border border-1 rounded">
            <h4>Sélectionner le type de mission</h4>
              <?php 
                foreach($parameters['type'] as $type) {
                  ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="type-<?= $type['row_id']?>" value="<?= $type['row_id']?>">
                    <label class="form-check-label" for="type-<?= $type['row_id']?>">
                      <?= $type['spe_name'] ?>
                    </label>
                  </div>
                <?php
                }
              ?>
          </div>

          <div class="mb-4 p-2 border border-1 rounded">
            <h4>Sélectionner une ou plusieurs cibles</h4>
            <?php 
                foreach($parameters['target'] as $target) {
                  ?>
                  <div class="form-check" id="target">
                    <input class="form-check-input" type="checkbox" value="<?= $target['row_id']?>" id="target-<?= $target['row_id']?>" name="target">
                    <label class="form-check-label" for="target-<?= $target['row_id']?>">
                    <?= $target['firstname']." ".$target['lastname'] ." ( ". $target['adjective'] ." )"?>
                    </label>
                  </div>
                  <?php
                }
              ?>
          </div>
        </div>
      </div>
    </form>

    <form action="" method="post" id="mission-prepare">
      <div class="mb-4 p-2 border border-1 rounded">
        <h4>Sélectionner un ou plusieurs agents</h4>
        <div id="agent">

        </div>
      </div>

      <div class="mb-4 p-2 border border-1 rounded">
      <h4>Sélectionner un ou plusieurs contacts</h4>
        <div id="contact">

        </div>
      </div>

      <div class="mb-4 p-2 border border-1 rounded">
      <h4>Sélectionner les Planques</h4>
        <div id="hideout">

        </div>
      </div>
    </form>
  </section>
</main>