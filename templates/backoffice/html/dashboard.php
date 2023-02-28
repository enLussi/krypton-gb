<main>
  <?php 
    require_once 'navigation-admin.php';
  ?>
  <section class="container-xl shadow-sm px-5 py-4 mt-3 rounded bg-light">
    <h3 class="mb-5">Paramètres Généraux</h3>
    <form action="" method="POST">
      <div class="mb-4 p-2 border border-1 rounded">
        <div class="py-2 input-group">
          <span class="input-group-text">Nom du Site</span>
          <input type="text" class="form-control" id="title-website" name="title-website" required value="<?= $parameters['config']['site_name'] ?>">
        </div>
        <div class="py-2 input-group">
          <span class="input-group-text">Description du Site</span>
          <textarea 
            class="form-control" 
            id="description-website" 
            name="description-website" 
            rows="2"
          ><?= $parameters['config']['site_description'] ?></textarea>
        </div>
        <div class="py-2 input-group">
          <span class="input-group-text">Email de contact</span>
          <input type="email" class="form-control" id="email-contact" name="email-contact" value="<?= $parameters['config']['contact'] ?>">
        </div>
      </div>
      <div class="mb-4 p-2 border border-1 rounded">
        <div class="py-2 form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="upkeep-checkbox" name="upkeep-checkbox" 
            <?= $parameters['config']['upkeep']?"checked":"" ?>>
          <label class="form-check-label" for="upkeep-checkbox">Site en maintenance</label>
        </div>
        <div class="py-2 input-group">
          <span class="input-group-text">Message de maintenance</span>
          <textarea 
            class="form-control" 
            id="upkeep-message" 
            name="upkeep-message" 
            rows="2"
          ><?= $parameters['config']['upkeep_message'] ?></textarea>
        </div>
      </div>
      <div class="mb-4 p-2 border border-1 rounded">
        <div class="py-2 form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="error-checkbox" name="error-checkbox"
            <?= $parameters['config']['error_display']?"checked":"" ?>>
          <label class="form-check-label" for="error-checkbox">Affichage des erreurs</label>
        </div>
      </div>
      <div class="mb-4 p-2 border border-1 rounded">
        <div class="py-2 form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="cookie-checkbox" name="cookie-checkbox"
            <?= $parameters['config']['cookie_enabled']?"checked":"" ?>>
          <label class="form-check-label" for="cookie-checkbox">Activation des cookies</label>
        </div>
        <div class="py-2">
          <label for="cookie-duration" class="form-label w-100">Durée des cookie 
            <output id="cookie-duration-output"><?= $parameters['config']['cookie_duration'] ?></output>
          </label>
          <input type="range" class="form-range w-50" id="cookie-duration" name="cookie-duration" min="3600" max="86400" step="600"
          value="<?= $parameters['config']['cookie_duration'] ?>">  
        </div>
      </div>
      <div class="row justify-content-end">
        <button type="submit" class="btn btn-primary col-2">Valider les changements</button>
      </div>   
    </form>
</section>
</main>