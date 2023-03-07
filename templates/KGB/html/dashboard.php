<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>
  <section>
      <div class="card card-body">
        <?php
          foreach($parameters['missions'] as $mission) {
        ?>
          <div class="list">
            <p><?= $mission->getName_code() ?></p>
            <p><?= $mission->getDescription() ?></p>
            <p><?= $parameters['country'][$mission->getCountry()]['noun'] ?></p>
            <p><?= $parameters['status'][$mission->getStatus()-1]['label'] ?></p>
            <a role="button" href="/admin/kgb-mission?mission=<?= $mission->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="mission-<?= $mission->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button>
          </div>
        <?php
          }
        ?>
      </div>
      <div id="involved" class="card card-body">
        <input type="text" name="search-involved" id="search-involved" placeholder="">
      <?php
          foreach($parameters['agents'] as $agent) {
        ?>
          <div class="list">
            <p><?= $agent->getName_code() ?></p>
            <p><?= $agent->getFirstname() . " " . $agent->getLastname() ?></p>
            <p><?= implode(', ',$agent->getSpecialities()) ?></p>
            <p><?= $agent->getNationality() ?></p>
            <a role="button" href="/admin/kgb-involved?agent=<?= $agent->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="involved-<?= $agent->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button>
          </div>
        <?php
          }
        ?>
        <?php
          foreach($parameters['contacts'] as $contact) {
        ?>
          <div class="list">
            <p><?= $contact->getName_code() ?></p>
            <p><?= $contact->getFirstname() . " " . $contact->getLastname() ?></p>
            <p><?= $contact->getNationality() ?></p>
            <a role="button" href="/admin/kgb-involved?contact=<?= $contact->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="involved-<?= $contact->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button>
          </div>
        <?php
          }
        ?>
        <?php
          foreach($parameters['targets'] as $target) {
        ?>
          <div class="list">
            <p><?= $target->getName_code() ?></p>
            <p><?= $target->getFirstname() . " " . $target->getLastname() ?></p>
            <p><?= $target->getNationality() ?></p>
            <a role="button" href="/admin/kgb-involved?target=<?= $target->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="involved-<?=$target->getId()?>" type="button" class="btn btn-danger btn-sm remove">Remove</button>
          </div>
        <?php
          }
        ?>
      </div>
      <div class="card card-body">
      <?php
          foreach($parameters['hideouts'] as $hideout) {
        ?>
          <div class="list">
            <p><?= $hideout->getName_code() ?></p>
            <p><?= $hideout->getAddress() ?></p>
            <p><?= $hideout->getCountry() ?></p>
            <p><?= $hideout->getType() ?></p>
            <a role="button" href="/admin/kgb-hideout?hideout=<?= $hideout->getId() ?>" class="btn btn-primary btn-sm">Modify</a>
            <button id="hideout-<?= $hideout->getId() ?>" type="button" class="btn btn-danger btn-sm remove">Remove</button>
          </div>
        <?php
          }
        ?>
      </div>
    </div>
  </section>
</main>