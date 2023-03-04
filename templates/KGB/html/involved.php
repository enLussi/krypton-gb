<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>


  <section>
    <form action="" method="post" id="mission-involved">
      <div class="input-group">
        <span class="input-group-text">Prénom et Nom de l'agent</span>
        <input type="text" aria-label="First name" class="form-control" name="firstname" required>
        <input type="text" aria-label="Last name" class="form-control" name="lastname" required>
      </div>

      <div>
        <label for="birthday">Date de naissance</label>
        <input type="date" name="birthday" id="birthday" required>
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

      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom de code</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="name_code" required>
      </div>

      <div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="involved" id="involved1" value="1" required>
          <label class="form-check-label" for="involved1">
            Agent
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="involved" id="involved2" value="2" required>
          <label class="form-check-label" for="involved2">
            Contact
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="involved" id="involved3" value="3" required>
          <label class="form-check-label" for="involved3">
            Cible
          </label>
        </div>
      </div>

      <div id="speciality" style="display: none">
        <?php 
          foreach($parameters['type'] as $type) {
            ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="type[]" id="type-<?= $type['row_id']?>" value="<?= $type['row_id']?>">
              <label class="form-check-label" for="type-<?= $type['row_id']?>">
                <?= $type['spe_name'] ?>
              </label>
            </div>
          <?php
          }
        ?>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary me-md-2" type="submit" id="submitter" form="mission-involved">Créer la mission</button>
      </div>

    </form>
  </section>
</main>