<?php
require templatePath() . "/partials/header.php";
?>

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <?php require templatePath() . "/partials/success.php"; ?>
                <?php require templatePath() . "/partials/errors.php"; ?>
                <div class="block-flat">
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="10%"></th>
                            <th> Title </th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php $i = 1; foreach($results as $result):?>
                        <tr>
                            <td><?php echo $i; $i++ ?></td>
                            <td><a href="index.php?page=showPoll&id=<?= $result[0] ?>"><?php echo $result[2] ?></a>
                              <button>
                                  <a href="index.php?page=deletePoll&id=<?= $result[0]?> " >
                                      apagar
                                  </a>
                              </button>
                                <button>
                                    <a href="index.php?page=editPoll&id=<?= $result[0]?> " >
                                        editar
                                    </a>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        </tbody>
                    </table>
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