<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>
  <section class="container my-3">
      <div class="card card-body my-2">
        <h3>Liste des Missions</h3>
        <input class="w-50" type="search" name="search-mission" id="search-mission" placeholder="Entrez le titre ou le nom de code de la mission">
        <div id="">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Nom de code</th>
                <th scope="col">Statut de la mission</th>
                <th scope="col">Pays</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="mission-result">

        <?php
          foreach($parameters['missions'] as $mission) {
        ?>
          <tr>
            <td><?= $mission->getName_code() ?></td>
            <td><?= $mission->getStatus_label() ?></td>
            <td><?= $mission->getCountry_name() ?></td>
            <td><a role="button" href="/admin/kgb-mission?mission=<?= $mission->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="mission-<?= $mission->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
          </div>
        <?php
          }
        ?>
                      
          </tbody>
        </table>
        </div>
      </div>
      <div id="involved" class="card card-body my-2">
        <h3>Liste des Agents/Contacts/Cibles</h3>
        <div class="row">
          <input class="col-5" type="search" name="search-involved" id="search-involved" placeholder="Entrez le nom de code, le prénom ou le nom de la personne">
          <select id="involved-select" name="involved-select" class="col-3" aria-label="" required>
            <option value="0" selected>Sélectionner un type de Personne</option>
            <option value="1" >Agents</option>
            <option value="2" >Contacts</option>
            <option value="3" >Cibles</option>
          </select>
        </div>

        <div >
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Nom de code</th>
                <th scope="col">Nom complet</th>
                <th scope="col">Nationalité</th>
                <th scope="col">Spécialités</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="involved-result">
        <?php
          foreach($parameters['agents'] as $agent) {
        ?>
          <tr>
            <td><?= $agent->getName_code() ?></td>
            <td><?= $agent->getFirstname() . " " . $agent->getLastname() ?></td>
            <td><?= $agent->getNationality() ?></td>
            <td><?= implode(', ',$agent->getSpecialities()) ?></td>
            <td><a role="button" href="/admin/kgb-involved?agent=<?= $agent->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="involved-<?= $agent->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
          </tr>
        <?php
          }
        ?>
        <?php
          foreach($parameters['contacts'] as $contact) {
        ?>
          <tr>
            <td><?= $contact->getName_code() ?></td>
            <td><?= $contact->getFirstname() . " " . $contact->getLastname() ?></td>
            <td><?= $contact->getNationality() ?></td>
            <td></td>
            <td><a role="button" href="/admin/kgb-involved?contact=<?= $contact->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="involved-<?= $contact->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button>
          </tr>
        <?php
          }
        ?>
        <?php
          foreach($parameters['targets'] as $target) {
        ?>
          <tr>
            <td><?= $target->getName_code() ?></td>
            <td><?= $target->getFirstname() . " " . $target->getLastname() ?></td>
            <td><?= $target->getNationality() ?></td>
            <td></td>
            <td><a role="button" href="/admin/kgb-involved?target=<?= $target->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="involved-<?=$target->getId()?>" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
          </tr>
        <?php
          }
        ?>
          </tbody>
        </table>
        </div>
      </div>
        
      
      <div class="card card-body my-2">
        <h3>Liste des Planques</h3>
          <input class="w-50" type="search" name="search-hideout" id="search-hideout" placeholder=" Entrez le nom de code de la Planque">
          <div id="hideout-result">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Nom de code</th>
                <th scope="col">Adresse</th>
                <th scope="col">Pays</th>
                <th scope="col">Type de Planque</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="hideout-result">
          <?php
            foreach($parameters['hideouts'] as $hideout) {
          ?>
            <tr>
              <td><?= $hideout->getName_code() ?></td>
              <td><?= $hideout->getAddress() ?></td>
              <td><?= $hideout->getCountry() ?></p>
              <td><?= $hideout->getType() ?></td>
              <td><a role="button" href="/admin/kgb-hideout?hideout=<?= $hideout->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
              <button id="hideout-<?= $hideout->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button></td>
            </tr>
          <?php
            }
          ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>