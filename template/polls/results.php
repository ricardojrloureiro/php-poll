<?php
require templatePath() . "/partials/header.php";
?>

    <script>
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(
                <?= $jsonArray ?>
            );

            var options = {
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <?php require templatePath() . "/partials/success.php"; ?>
                <div class="block-flat">
                    <div class="row">
                        <div class="col-md-6 poll-div">
                            <h1><?= $poll->title ?> results</h1>
                            <div id="piechart" style="height: 500px;"></div>
                        </div>
                        <div class="col-md-6" >
                        <?php if( endsWith($poll->image,".mp4")): ?>
                            <video width="500" controls>
                              <source src="uploads/<?= $poll->image; ?>" type="video/mp4">
                            </video>
                        <?php elseif(endsWith($poll->image,".webm") ): ?>
                            <video width="500" controls>
                              <source src="uploads/<?= $poll->image; ?>" type="video/webm">
                            </video>
                        <?php elseif( endsWith($poll->image,".ogg") ): ?>
                            <video width="500" controls>
                              <source src="uploads/<?= $poll->image; ?>" type="video/ogg">
                            </video>
                        <?php else: ?>
                        <img src="uploads/<?= $poll->image; ?>" width="500" />

                       <?php endif; ?>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container -->


<?php
require templatePath() . "/partials/footer.php";
?>