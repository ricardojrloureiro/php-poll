<?php if (isset($_SESSION['errors'])): ?>
	<?php foreach($_SESSION['errors'] as $error): ?>
		<div class="alert alert-danger" role="alert">
		  <span class="sr-only">Error:</span>
		  <?php echo $error; ?>
		</div>
	<?php endforeach; ?>
	<?php unset($_SESSION['errors']); ?>
<?php endif; ?>