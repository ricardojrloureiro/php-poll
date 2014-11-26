<?php
session_start();
include 'db.php';
require __DIR__."/template/header.php"; ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php if (isset($_SESSION['errors'])): ?>
				<?php foreach($_SESSION['errors'] as $error): ?>
					<div class="alert alert-danger" role="alert">
					  <span class="sr-only">Error:</span>
					  <?php echo $error; ?>
					</div>
				<?php endforeach; ?>
				<?php unset($_SESSION['errors']); ?>
			<?php endif; ?>
			<div class="block-flat">
				<table class="table">
				  <thead>
				    <tr>
				      <th width="10%">Poll id</th>
				      <th> Title </th>
				    </tr>
				  </thead>
				  <tbody>
                    <?php
                    $db = new \Db;
                    $results = $db->query(
                        "SELECT * FROM Poll",
                        array()
                    );
                    ?>
                    <?php foreach($results as $result):?>
				    <tr>
				      <td><?php echo $result['poll_id'] ?></td>
				      <td><?php echo $result['title'] ?></td>
				    </tr>
                    <?php endforeach;?>
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
			</div>
		</div>
	</div>

</div><!-- /.container -->

<?php require __DIR__."/template/footer.php"; ?>