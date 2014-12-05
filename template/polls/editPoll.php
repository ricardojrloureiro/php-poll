<?php
require templatePath() . "/partials/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php require templatePath() . "/partials/errors.php"; ?>
            <div class="block-flat">
                <div class="row">
                    <div class="col-md-6 poll-div">
                        <form role="form"  action="index.php?page=overWritePoll&id=<?=$poll->id?>"
                              method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <input type="text" class="form-control" name="title"
                                       id="title" value="<?= $poll->title ?>">
                            </div>

                            <div class="checkbox">
                                <label>
                                <?php if($poll->public): ?>
                                    <input type="checkbox" name="public" checked>
                                <?php else:?>
                                     <input type="checkbox" name="public">
                                <?php endif?>
                                        Public Poll
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                <?php
                                  if($poll->multiple): ?>
                                <input type="checkbox" name="multiple" checked>
                                <?php else:?>
                                <input type="checkbox" name="multiple">
                                <?php endif?>
                                Allow multiple choices?
                                </label>
                            </div>

                            <!-- todo add default image -->

                            <div class="form-group">
                                Poll Image
                                <input type="file" value="<?= $poll->image; ?>"  id="image" name="image">
                            </div>

                            <div id="poll-options">
                                <?php foreach($poll->options as $option):?>
                                <div class="form-group">
                                        <input type="text" class="form-control" name="option[]"
                                               id="option[]" placeholder="Insert answer option"
                                               value="<?=$option['value']?>"  >
                                    </div>
                                <?php endforeach?>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="option[]"
                                           id="option[]" placeholder="Insert answer option">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default poll-btn">Edit Poll</button>
                        </form>
                    </div>
                     <div class="col-md-6">
                        <img id="imagePreview" src="uploads/<?= $poll->image; ?>"  width="500">
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->
<?php require templatePath() . "/partials/footer.php"; ?>