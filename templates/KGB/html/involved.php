<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>


  <section class="container my-3">
    <h3 class="mb-5"><?= count($parameters['involved']) > 0 ? "Modifier la Partie prenante" : "Créer une Partie prenante" ?></h3>
    <form action="" method="post" id="mission-involved">
      <input type="hidden" name="id" value="<?= count($parameters['involved']) > 0 ? $parameters['involved']['row_id'] : "" ?>">
      <input type="hidden" name="modify" value="<?= count($parameters['involved']) > 0 ? true : false ?>">

      <div class="mb-4 p-2 border border-1 rounded">
        <div class="row row-cols-2">
          <div class="col-6">
            <div class="input-group mb-3">
              <span class="input-group-text">Prénom et Nom</span>
              <input 
                type="text" 
                aria-label="First name" 
                class="form-control" 
                name="firstname"
                value="<?= count($parameters['involved']) > 0 ? $parameters['involved']['firstname'] : "" ?>" 
                required
                >
              <input 
                type="text" 
                aria-label="Last name" 
                class="form-control" 
                name="lastname" 
                value="<?= count($parameters['involved']) > 0 ? $parameters['involved']['lastname'] : "" ?>"
                required
              >
            </div>
          </div>
          <div class="col-6">
            <div class="p-1 border border-1 rounded">
              <label for="birthdate">Date de naissance</label>
              <input 
                type="date" 
                name="birthdate" 
                id="birthdate"
                value=<?= count($parameters['involved']) > 0 ? $parameters['involved']['birthdate'] : "" ?> 
                required
                >
            </div>
          </div>
          <div class="col-6">
            <div class="input-group mb-3">
              <select id="country" name="country" class="form-select" aria-label="" required>
                <option value="" selected>Nationalité</option>
                <?php 
                  foreach($parameters['country'] as $country) {
                    ?>
                    <option value="<?= $country['row_id']?>"
                    <?= count($parameters['involved']) > 0 ? 
                      ($parameters['involved']['country_id']===$country['row_id'] ? "selected" : "") : "" ?>
                    ><?= $country['noun'] ?></option>
                    <?php
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="input-group mb-3">
              <span class="input-group-text" id="inputGroup-sizing-default">Nom de code</span>
              <input 
                type="text" 
                class="form-control" 
                aria-label="Sizing example input" 
                aria-describedby="inputGroup-sizing-default" 
                name="name_code" 
                value="<?= count($parameters['involved']) > 0 ? $parameters['involved']['name_code'] : "" ?>"
                required
              >
            </div>
          </div>
      
          <div class="col-12">
            <div class="p-2 mx-2 my-2 border border-1 rounded">
              <h4>Sélectionner le Role de la partie prenante</h4>
              <div id="type" class="px-3 row row-cols-5">
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="radio" 
                    name="involved" 
                    id="involved1" 
                    value="1" 
                    <?= (count($parameters['involved']) > 0 && isset($_GET['agent'])) ? "checked" : "" ?>
                    required
                  >
                  <label class="form-check-label" for="involved1">
                    Agent
                  </label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="radio" 
                    name="involved" 
                    id="involved2" 
                    value="2" 
                    <?= (count($parameters['involved']) > 0 && isset($_GET['contact'])) ? "checked" : "" ?>
                    required
                  >
                  <label class="form-check-label" for="involved2">
                    Contact
                  </label>
                </div>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="radio" 
                    name="involved" 
                    id="involved3" 
                    value="3" 
                    <?= (count($parameters['involved']) > 0 && isset($_GET['target'])) ? "checked" : "" ?>
                    required
                    >
                  <label class="form-check-label" for="involved3">
                    Cible
                  </label>
                </div>
              </div>
            </div>
            <div id="speciality" style="display: none" class="p-2 mx-2 my-2 border border-1 rounded">
              <h4>Sélectionner le Role de la partie prenante</h4>
              <div id="type" class="px-3 row row-cols-5">
                <?php 
                  foreach($parameters['type'] as $type) {
                    ?>
                    <div class="form-check">
                      <input 
                        class="form-check-input" 
                        type="checkbox" 
                        name="type[]" 
                        id="type-<?= $type['row_id']?>" 
                        value="<?= $type['row_id']?>"
                        <?= isset($parameters['involved']['specialities']) ? ((count($parameters['involved']) > 0 && in_array($type['row_id'], $parameters['involved']['specialities']) && isset($_GET['agent'])) ? "checked" : "") : "" ?>
                        >
                      <label class="form-check-label" for="type-<?= $type['row_id']?>">
                        <?= $type['spe_name'] ?>
                      </label>
                    </div>
                  <?php
                  }
                ?>
              </div>
            </div>

          </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button class="btn btn-primary me-md-2" type="submit" id="submitter" form="mission-involved"
          ><?= count($parameters['involved']) > 0 ? "Modifier la Partie prenante" : "Créer la Partie prenante" ?></button>
        </div>
      </div>

    </form>
  </section>
</main>