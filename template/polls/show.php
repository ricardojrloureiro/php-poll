<?php
require templatePath() . "/partials/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php include __DIR__ . "/../partials/errors.php"; ?>
            <?php include __DIR__ . "/../partials/success.php"; ?>
            <div class="block-flat">
                <div class="row">
                    <div class="col-md-4 poll-div">
                        <h1><?= $poll->title ?></h1>
                        <form role="form" action="index.php?page=showPoll&id=<?= $poll->id ?>" method="POST">
                        <?php foreach($poll->options as $option): ?>
                            <?php if($poll->multiple): ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="option[]" value="<?= $option['option_id'] ?>"><?= $option['value'] ?>
                                    </label>
                                </div>
                            <?php else: ?>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="option" value="<?= $option['option_id'] ?>"><?= $option['value'] ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                            <input type="submit" value="Vote" class="btn btn-default">
                        </form>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <img src="uploads/<?= $poll->image; ?>" />
                        <br />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="fb-share-button" data-layout="button_count"></div>
                        <div style="padding-top:10px"></div>
                        <a class="twitter-share-button"
                           href="https://twitter.com/share">
                            Tweet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->
<?php
require templatePath() . "/partials/footer.php";
?>