<?php if (isset($_SESSION['success'])): ?>
    <?php foreach($_SESSION['success'] as $success): ?>
        <div class="alert alert-success" role="alert">
            <span class="sr-only">Success:</span>
            <?php echo $success; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>