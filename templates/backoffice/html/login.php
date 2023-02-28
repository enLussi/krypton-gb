
<main class="container-fluid">
  <section class="full-h bg-dark row justify-content-md-center align-items-md-center">
    <div class="bg-light col-3 rounded p-4">
      <h3 class="mx-2 my-4">Sign up</h3>
      <p> 
      <?php 
      if ($parameters[0] === false) {
        echo 'Wrong credentials';
      }
      ?>
      </p>

      <form class="container mt-3 mb-4" action="#" id="idForm" method="post">
        <div class="row mb-3 g-3">
          <label class="col-auto" for="idAdmin">Username</label>
          <div class="col-12">
            <input class="form-control" name="idAdmin" type="text" id="idAdmin" required="" placeholder=" "/>
          </div>
        </div>
        <div class="row mb-3 g-3">
          <label class="col-auto" for="pass">Password</label>
          <div class="col-12">
            <input class="form-control" name="pass" type="password" id="pass" required="" placeholder=" "/>
          </div>
        </div>
        <div class="row justify-content-end pt-3">
          <button class="btn btn-primary col-3" type="submit">Login</button>
        </div>
        <a class="link-dark text-sm text-decoration-none" href="/"><-back to home page</a>
      </form>
    </div>
  </section>
</main>