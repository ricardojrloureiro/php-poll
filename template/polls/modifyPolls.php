<?php
require templatePath() . "/partials/header.php";
?>

    <div class="modal fade" id="deletePollModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Are you sure you want to delete this poll?</h4>
                </div>
                <div class="modal-body">
                    <p>This action is irreversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="deleteLink" type="button" class="btn btn-danger">Yes, I'm sure!</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
                            <th>Title</th>
                            <th>Management</th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php $i = 1; foreach($results as $result):?>
                        <tr>
                            <td><?php echo $i; $i++ ?></td>
                            <td>
                                <a href="index.php?page=showPoll&id=<?= $result[0] ?>"><?php echo $result[2] ?></a>
                            </td>
                            <td>
                                <a class="btn btn-default" href="index.php?page=editPoll&id=<?= $result[0]?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default" data-delete-url="index.php?page=deletePoll&id=<?= $result[0]?>" data-toggle="modal" data-target="#deletePollModal">
                                    <i class="fa fa-times"></i>
                                </a>
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