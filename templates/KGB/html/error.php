<main>
  <?php 
    require_once AdminNavigation::getInstance()->getAdminNavigation();
  ?>

  <section>
    <h3>Erreur</h3>
    <p><?= $parameters['message'] ?></p>
    <a href="/admin/kgb">Revenir à la page d'accueil</a>
  </section>
</main>