<?php

// echo '<pre>';
// var_dump($parameters['mission']);
// echo '</pre>';

?>
<main>
  <header>
    <div class="stripe">
      <h2><a href="/">Krypton General Bureaucracy</a></h2>
      <p class="connexion"><a href="/admin">Connexion</a></p>
    </div>
  </header>
  <section>
    <img class="confidential" src="/assets/imgs/pngegg.png" alt="">
    <div>
      <p><span class="label">Nom de Code de la Mission : </span><span class="typed"><?= $parameters['mission']->getName_code() ?></span></p>
      <p><span class="label">Titre : </span><span class="typed"><?= $parameters['mission']->getTitle() ?></span></p>
      <p><span class="label">Type de Mission : </span><span class="typed"><?= $parameters['mission']->getType_name() ?></span></p>
      <p><span class="label">Statut de la Mission : </span><span class="typed"><?= $parameters['mission']->getStatus_label() ?></span></p>
    </div>
    <div class="agents list">
      <p><span class="label" >Agents associés :</span></p>
      <ul>
        <?php foreach($parameters['mission']->getAgents() as $agent) {
          echo '<li class="typed">'.$agent->getFirstname().' '.$agent->getLastname().' ('.$agent->getNationality().')</li>';
        } ?>
      </ul>
    </div>

    <div class="assets">
      <div class="list">
        <p><span class="label" >Cibles :</span></p>
        <ul>
          <?php foreach($parameters['mission']->getTargets() as $target) {
            echo '<li class="typed">'.$target->getFirstname().' '.$target->getLastname().' ('.$target->getNationality().')</li>';
          } ?>
        </ul>
      </div>
      <div class="list">
        <p><span class="label" >Contacts :</span></p>
        <ul>
          <?php foreach($parameters['mission']->getContacts() as $contact) {
            echo '<li class="typed">'.$contact->getFirstname().' '.$contact->getLastname().' ('.$contact->getNationality().')</li>';
          } ?>
        </ul>
      </div>
      <div class="list">
        <p><span class="label" >Planque :</span></p>
        <ul>
          <?php foreach($parameters['mission']->getHideouts() as $hideout) {
            echo '<li class="typed">'.$hideout->getName_code()." ".$hideout->getAddress()." (".$hideout->getType().")</li>";
          } ?>
        </ul>
      </div>
    </div>
    <div class="description-container">
      <h3 class="label">Description : </h3>
      <p class="typed description"><?= $parameters['mission']->getDescription() ?></p>
    </div>
  </section>
  <footer>
    <div>
      <img src="/assets/imgs/logoKGB.png" alt="" width="250">
    </div>
    <div class="stripe">
      <p>Toutes les données affichées sont générées aléatoirement ou créer par un administrateur de manière arbitraire 
        et ont un but purement éducatif.</p>
    </div>
  </footer>
</main>