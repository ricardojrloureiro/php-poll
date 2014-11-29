<?php
require templatePath() . "/partials/header.php";
?>


<?php
    $db = new \Poll\Db;
    $results = $db->query(
        "select COUNT(*),answers.option_id,options.value from answers
                INNER JOIN options on options.option_id = answers.option_id
                AND options.poll_id = ? group by answers.option_id;",
        array($_GET['id'])
    );
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