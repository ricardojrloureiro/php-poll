<?php
require templatePath() . "/partials/header.php"; ?>

<div class="container">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <?php require templatePath() . "/partials/errors.php"; ?>
        <div class="block-flat">
          <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <form role="form" action="index.php?page=register" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="usernameRegister" placeholder="Enter username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
              </div>
              <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
              </div>
              <button type="submit" id="registerButton" class="btn btn-default">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- /.container -->

<?php require templatePath() . "/partials/footer.php"; ?>