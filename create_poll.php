<?php
session_start();
require __DIR__."/template/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="block-flat">
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <form role="form" action="router.php?page=create_poll" method="POST">
                            <div class="form-group">
                                <label for="title">Pole Question</label>
                                <input type="text" class="form-control" name="title"
                                       id="title" placeholder="Insert poll question">
                            </div>
                            <button type="submit" class="btn btn-default">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->

<?php require __DIR__."/template/footer.php"; ?>