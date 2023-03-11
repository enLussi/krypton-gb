<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>

  <section class="container my-3">
    <h3 class="mb-5"><?= count($parameters['mission']) > 0 ? "Modifier la Mission" : "Créer une Mission" ?></h3>
    <form action="" method="post" id="mission-prepare">
      <input type="hidden" name="id" value="<?= count($parameters['mission']) > 0 ? $parameters['mission'][0]->getID() : "" ?>">
      <input type="hidden" name="modify" value="<?= count($parameters['mission']) > 0 ? true : false ?>">


      <div class="mb-4 p-2 border border-1 rounded">
        <div class="row">
          <!-- Titre de la mission -->
          <div class="py-2 input-group col">
            <span class="input-group-text">Titre de la mission</span>
            <input 
              type="text" 
              class="form-control" 
              id="title-mission" 
              name="title-mission" 
              required 
              value="<?= count($parameters['mission']) > 0 ? $parameters['mission'][0]->getTitle() : "" ?>"
            >
          </div>
          <!-- Nom de code de la mission -->
          <div class="py-2 input-group col">
            <span class="input-group-text">Nom de code</span>
            <input 
              type="text" 
              class="form-control" 
              id="name_code" 
              name="name_code" 
              required 
              value="<?= count($parameters['mission']) > 0 ? $parameters['mission'][0]->getName_code() : "" ?>"
            >
          </div>
          <!-- Statut de la mission -->
          <div class="py-2 col">
            <select id="status" name="status" class="form-select" aria-label="" required>
              <option value="" selected>Statut de la mission</option>
              <?php 
                foreach($parameters['status'] as $status) {
                  ?>
                  <option 
                    <?= count($parameters['mission']) > 0 ? 
                      ($parameters['mission'][0]->getStatus() == $status['row_id'] ? "selected" : "" ) 
                    : "" ?>
                    value="<?= $status['row_id']?>"
                  ><?= $status['label'] ?></option>
                  <?php
                }
              ?>
            </select>
          </div>

        </div>

        <!-- Description de la mission -->
        <div class="py-2 input-group">
          <span class="input-group-text">Description de la mission</span>
          <textarea 
            class="form-control" 
            id="description-mission" 
            name="description-mission" 
            rows="5"
            required
          ><?= count($parameters['mission']) > 0 ? $parameters['mission'][0]->getDescription() : "" ?></textarea>
        </div>

      </div>



      <div class="mb-4 p-2 border border-1 rounded">
        <div class="row">
          <div class="mx-3 my-2 border border-1 rounded col">
            <h4>Sélectionner le type de mission</h4>

            <?php 
              foreach($parameters['type'] as $type) {
                ?>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="radio" name="type[]" 
                    id="type-<?= $type['row_id']?>" 
                    value="<?= $type['row_id']?>"
                    <?= count($parameters['mission']) > 0 ? 
                      ($parameters['mission'][0]->getType() == $type['row_id'] ? "checked" : "" ) 
                    : "" ?>
                  >
                  <label class="form-check-label" for="type-<?= $type['row_id']?>">
                    <?= $type['spe_name'] ?>
                  </label>
                </div>
              <?php
              }
            ?>
          </div>

          <div class="col">
            <div class="py-2">
              <select id="country" name="country" class="form-select" aria-label="" required>
                <option value="" selected>Pays concerné</option>
                <?php 
                  foreach($parameters['country'] as $country) {
                    ?>
                    <option 
                      value="<?= $country['row_id']?>"
                      <?= count($parameters['mission']) > 0 ? 
                        ($parameters['mission'][0]->getCountry() == $country['row_id'] ? "selected" : "" ) 
                      : "" ?>
                    ><?= $country['noun'] ?></option>
                    <?php
                  }
                ?>
              </select>
            </div>
            <div class="p-1 my-2  border border-1 rounded">
              <label for="start">Date de départ de la mission</label>
              <input 
                type="date" 
                name="start" 
                id="start" 
                value="<?= count($parameters['mission']) > 0 ? $parameters['mission'][0]->getStart_date() : "" ?>"
                required
              >
            </div>
            <div class="p-1 my-2 border border-1 rounded">
              <label for="start">Date de fin de  mission</label>
              <input 
                type="date" 
                name="end" 
                id="end" 
                value="<?= count($parameters['mission']) > 0 ? $parameters['mission'][0]->getEnd_date() : "" ?>"
                required
              >
            </div>
          </div>
        </div>
        
        <div class="p-2 mx-2 my-2 border border-1 rounded" >
          <h4>Sélectionner une ou plusieurs cibles</h4>
            <div id="target" class="row row-cols-4">
              <?php 

                if(count($parameters['mission']) > 0){
                  $targets_id = [];
                  foreach($parameters['mission'][0]->getTargets() as $t) {
                    $targets_id = [...$targets_id, $t->getID()];
                  }
                }
                foreach($parameters['targets'] as $target) {
                  ?>
                  <div class="form-check">
                    <input 
                      class="" 
                      type="checkbox" 
                      value="<?= $target->getID()?>" 
                      id="target-<?= $target->getID()?>" 
                      name="target[]"
                      <?= count($parameters['mission']) > 0 ? 
                        (in_array( $target->getID() ,$targets_id) ? "checked" : "" ) 
                      : "" ?>
                    >
                    <label class="" for="target-<?=$target->getID()?>">
                    <?= $target->getFirstname()." ".$target->getLastname() ." ( ". $target->getNationality() ." )"?>
                    </label>
                  </div>
                  <?php
                }
                ?>
            </div>
        </div>
      </div>
    </form>


    <form action="" method="post" id="mission-involved">
      <div class="mb-4 p-2 border border-1 rounded">
        <div class="p-2 mx-2 my-2 border border-1 rounded">
          <h4>Sélectionner un ou plusieurs agents</h4>
          <div id="agent" class="px-4 row row-cols-4">
            <?php 
              if(count($parameters['mission']) > 0) {
                $agents_id = [];
                foreach($parameters['mission'][0]->getAgents() as $a) {
                  $agents_id = [...$agents_id, $a->getID()];
                }
              }
              foreach($parameters['agents'] as $agent) { ?>
              <div class="form-check">
                <input 
                  class="form-check-input" 
                  type="checkbox" 
                  value="<?= $agent->getID() ?>" 
                  id="agent-<?= $agent->getID() ?>" 
                  name="agent[]"
                  <?= count($parameters['mission']) > 0 ? 
                    (in_array($agent->getID(), $agents_id) ? "checked" : "" ) 
                  : "disabled" ?>
                >
                <label class="form-check-label" for="agent-<?= $agent->getId() ?>">
                  <?= $agent->getFirstname() ." ". $agent->getLastname() ." ". $agent->getNationality()  ?>
                </label>
              </div>
            <?php } ?>
          </div>
        </div>        

      </div>         
      <div class="mb-4 p-2 border border-1 rounded">
        <div class="p-2 mx-2 my-2 border border-1 rounded">
          <h4>Sélectionner un ou plusieurs contacts</h4>
          <div id="contact" class="px-4 row row-cols-4">
            <?php 
              if(count($parameters['mission']) > 0) {
                $contacts_id = [];
                foreach($parameters['mission'][0]->getContacts() as $c) {
                  $contacts_id = [...$contacts_id, $c->getID()];
                }
              }
              foreach($parameters['contacts'] as $contact) { ?>
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="checkbox" 
                    value="<?= $contact->getID() ?>" 
                    id="contact-<?= $contact->getID() ?>" 
                    name="contact[]"
                    <?= count($parameters['mission']) > 0 ? 
                      (in_array($contact->getID(), $contacts_id) ? "checked" : "" ) 
                    : "disabled" ?>
                    >
                  <label class="form-check-label" for="contact-<?= $contact->getId() ?>">
                    <?= $contact->getFirstname() ." ". $contact->getLastname() ." ". $contact->getNationality()  ?>
                  </label>
                </div>
              <?php } ?>
          </div>
        </div>
      </div>

      <div class="mb-4 p-2 border border-1 rounded">
        <div class="p-2 mx-2 my-2 border border-1 rounded">
          <h4>Sélectionner les Planques</h4>
          <div id="hideout" class="px-4 row row-cols-4">
            <?php 
              if(isset($parameters['hideout-selected'])) {
                $hideouts_id = [];
                foreach($parameters['hideout-selected'] as $h) {
                  $hideouts_id = [...$hideouts_id, $h['hideout_id']];
                }
              }
              foreach($parameters['hideouts'] as $hideout) { ?>
              <div class="form-check">
                <input 
                  class="form-check-input" 
                  type="checkbox" 
                  value="<?= $hideout->getID() ?>" 
                  id="hideout-<?= $hideout->getID() ?>" 
                  name="hideout[]"
                  <?= isset($parameters['hideout-selected']) ? 
                    (in_array($hideout->getID(), $hideouts_id) ? "checked" : "" ) 
                  : "disabled" ?>
                  >
                <label class="form-check-label" for="hideout-<?= $hideout->getID() ?>">
                <?= $hideout->getType() ." ". $hideout->getCountry() ?>
                </label>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </form>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button class="btn btn-primary me-md-2" type="button" id="submitter" form="mission-prepare"
      ><?= count($parameters['mission']) > 0 ? "Modifier la Mission" : "Créer la Mission" ?></button>
    </div>

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