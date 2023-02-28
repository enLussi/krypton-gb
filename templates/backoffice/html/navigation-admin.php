<?php
$menu = AdminNavigation::getInstance()->getAdminNavigationLink();
?>

<nav class="navbar navbar-dark bg-dark sticky-top">
  <div class="container-fluid d-flex justify-content-start navbar_gap">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Agora</a>
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Agora</h5> 
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <p class="mx-3 text-white-50"><?= $_ENV['agora']['version']?></p>
      <p class="mx-3">Logged as <?= $_SESSION['user']?></p>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/" target="_blank">Retourner sur le site</a>
          </li>

          <?php 
            
            foreach($menu as $collapser => $links) {
              ?>

              <li class="nav-item">
                <p class="p-0 m-0">
                  <a 
                    class="nav-link" 
                    data-bs-toggle="collapse" 
                    href="#collapse<?= $collapser ?>" 
                    role="button" 
                    aria-expanded="false" 
                    aria-controls="collapseExample">
                    <?= $collapser ?> <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </a>
                </p>
                <div class="collapse" id="collapse<?= $collapser ?>">
                  <ul class="list-group list-group-flush p-2">
                    <?php
                      foreach($links as $link) {
                        ?>
                          <li class="list-group-item list-group-item-action bg-dark p-0">
                            <a class="nav-link" href="/admin/<?= $link['link'] ?>">
                              <?= $link['display'] ?>
                            </a>
                          </li>
                        <?php
                      }
                    ?>
                  </ul>
                </div>
              </li>

              <?php
            }

          ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/admin/logout">Déconnection</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>