<?php
session_start();
require __DIR__."/template/header.php"; ?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="block-flat">
                <div class="row">
                    <div class="col-md-4 col-md-offset-2 poll-div">
                        <form role="form" action="router.php?page=create_poll" method="POST">

                            <div class="form-group">
                                <input type="text" class="form-control" name="title"
                                       id="title" placeholder="Insert poll question">
                            </div>
                                <div class="poll-options">
                                    <div class="from-group">
                                        <input type="text" class="form-control" name="option[]"
                                               id="option[]" placeholder="Insert answer option">
                                    </div>
                                    <div class="from-group">
                                        <input type="text" class="form-control" name="option[]"
                                               id="option[]" placeholder="Insert answer option">
                                    </div>
                            </div>

                            <button class="btn btn-mini btn-primary add-poll poll-btn" type="button">+</button>

                            <button type="submit" class="btn btn-default poll-btn">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->
<?php require __DIR__."/template/footer.php"; ?>