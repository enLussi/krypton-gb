<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>

  <section>
    <form action="" method="post" id="mission-hideout">
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom de Code de la Planque</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="name_code" required>
      </div>

      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Adresse de la Planque</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="address" name="address" required>
      </div>

      <select id="country" name="country" class="form-select" aria-label="" required>
        <option value="" selected>Nationalité</option>
        <?php 
          foreach($parameters['country'] as $country) {
            ?>
            <option value="<?= $country['row_id']?>"><?= $country['noun'] ?></option>
            <?php
          }
        ?>
      </select>

      <div id="type">
        <?php 
          foreach($parameters['type'] as $type) {
            ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="hideout-type" id="type-<?= $type['row_id']?>" value="<?= $type['row_id']?>" required>
              <label class="form-check-label" for="type-<?= $type['row_id']?>">
                <?= $type['label'] ?>
              </label>
            </div>
          <?php
          }
        ?>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary me-md-2" type="submit" id="submitter" form="mission-hideout">Créer la mission</button>
      </div>

    </form>
  </section>

  <div class="modal" tabindex="-1" id="modal-warner-form" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Erreur dans le Formulaire</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal-close"></button>
        </div>
        <div class="modal-body">
          <p id="modal-warner-form-message"></p>
        </div>
      </div>
    </div>
  </div>
</main>