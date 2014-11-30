<?php
require templatePath() . "/partials/header.php";
?>

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <?php require templatePath() . "/partials/success.php"; ?>
                <div class="block-flat">
                    <?php foreach($results as $result): ?>
                    <?php echo ("ocorreu " . $result[0]. " // ". "opcao" . $result[1] . " // " . $result[2]);
                        ?>
                        <br>
                    <?php endforeach?>

                    <div class="row">
                        <div class="col-md-4 poll-div">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container -->


<?php
require templatePath() . "/partials/footer.php";
?>