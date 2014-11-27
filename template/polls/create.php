<?php
require templatePath() . "/partials/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="block-flat">
                <div class="row">
                    <div class="col-md-6 poll-div">

                        <?php require templatePath() . "/partials/errors.php"; ?>

                        <form role="form"  action="index.php?page=createPoll" method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <input type="text" class="form-control" name="title"
                                       id="title" placeholder="Poll question">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="public" checked>Public Poll
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="multiple" checked>Allow multiple choices?
                                </label>
                            </div>

                            <div class="form-group">
                                Poll Image
                                <input type="file" id="image" name="image">
                            </div>

                            <div id="poll-options">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="option[]"
                                           id="option[]" placeholder="Insert answer option">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="option[]"
                                           id="option[]" placeholder="Insert answer option">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default poll-btn">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->
<?php require templatePath() . "/partials/footer.php"; ?>