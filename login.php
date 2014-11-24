<?php require __DIR__.'/template/header.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
    <div class="block-flat">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form role="form" action="router.php?page=login" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
              </div>
              <button type="submit" class="btn btn-default">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- /.container -->

<?php require __DIR__.'/template/footer.php'; ?>