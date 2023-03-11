<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>

  <section class="container my-3">
    <h3 class="mb-5"><?= count($parameters['hideout']) > 0 ? "Modifier la planque" : "Créer une Planque" ?></h3>
    <form action="" method="post" id="mission-hideout">
    <input type="hidden" name="id" value="<?= count($parameters['hideout']) > 0 ? $parameters['hideout']['row_id'] : "" ?>">
    <input type="hidden" name="modify" value="<?= count($parameters['hideout']) > 0 ? true : false ?>">

    <div class="mb-4 p-2 border border-1 rounded">
      <div class="row row-cols-2">
        <div class="col-6">
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Nom de Code de la Planque</span>
            <input 
              type="text" 
              class="form-control" 
              aria-label="Sizing example input" 
              aria-describedby="inputGroup-sizing-default" 
              name="name_code"
              value="<?= count($parameters['hideout']) > 0 ? $parameters['hideout']['name_code'] : "" ?>" 
              required
            >
          </div>
        </div>
        <div class="col-6">
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Adresse de la Planque</span>
            <input 
              type="text" 
              class="form-control" 
              aria-label="Sizing example input" 
              aria-describedby="inputGroup-sizing-default" 
              id="address" 
              name="address" 
              value="<?= count($parameters['hideout']) > 0 ? $parameters['hideout']['address'] : "" ?>"
              required
            >
          </div>
        </div>
        <div class="col-6">
          <div class="input-group mb-3">
            <select id="country" name="country" class="form-select" aria-label="" required>
              <option value="" selected>Pays</option>
              <?php 
                foreach($parameters['country'] as $country) {
                  ?>
                  <option 
                    value="<?= $country['row_id']?>" 
                      <?=count($parameters['hideout']) > 0 ? 
                        ($parameters['hideout']['country_id']===$country['row_id']? "selected" : "") 
                      : "" ?>     
                  ><?= $country['noun'] ?></option>
                  <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-12">
          <div class="p-2 mx-2 my-2 border border-1 rounded">
            <h4>Sélectionner le type de Planque</h4>
            <div id="type" class="px-3 row row-cols-5">
              <?php 
                foreach($parameters['type'] as $type) {
                  ?>
                  <div class="form-check">
                    <input 
                      class="form-check-input" 
                      type="radio" 
                      name="hideout-type" 
                      id="type-<?= $type['row_id']?>" 
                      value="<?= $type['row_id']?>" 
                      <?=count($parameters['hideout']) > 0 ? 
                        ($parameters['hideout']['type_id']===$type['row_id']? "checked" : "") 
                      : "" ?>
                      required
                    >
                    <label class="form-check-label" for="type-<?= $type['row_id']?>">
                      <?= $type['label'] ?>
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
        <button class="btn btn-primary me-md-2" type="submit" id="submitter" form="mission-hideout"
          ><?= count($parameters['hideout']) > 0 ? "Modifier la planque" : "Créer la planque" ?></button>
      </div>
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