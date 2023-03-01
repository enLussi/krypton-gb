<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>

  <section>
    <!-- Liste des Missions avec un champs de recherche -->
  </section>
  <section>
    <h3 class="mb-5"></h3>
    <form action="" method="post" id="mission">

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
    </div>
    <div class="mb-4 p-2 border border-1 rounded">
      <select id="country" name="country" class="form-select" aria-label="Default select example">
        <option value="0" selected>Pays concerné</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>
    </form>
  </section>
</main>