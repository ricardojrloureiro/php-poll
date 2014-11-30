<?php

require __DIR__ . "/partials/header.php"; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include __DIR__ . "/partials/success.php"; ?>
                <?php include __DIR__ . "/partials/errors.php"; ?>
                <div class="block-flat">
                    <?php if(count($_SESSION['polls']) == 0): ?>
                        No polls yet.
                    <?php else: ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="10%"></th>
                                <th> Title </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($_SESSION['polls'] as $poll):?>
                                    <tr>
                                        <td><?php echo $i; $i++ ?></td>
                                        <td><a href="index.php?page=showPoll&id= <?= $poll['poll_id'] ?>"><?php echo $poll['title'] ?></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <ul class="pagination">
                                <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>

<?php require __DIR__ . "/partials/footer.php"; ?>