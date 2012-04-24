<?php if (isset($success)) : ?>
<!-- success message -->
<div class="notification success">
        <a href="javascript:viod(0)" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
        <p><strong>Success:</strong> <?php print $msg; ?></p>
</div>
<?php endif; ?>

<?php if (isset($error)) : ?>
<!-- error message -->
<div class="notification error">
        <a href="javascript:viod(0)" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
        <p><strong>Error:</strong> <?php print $msg; ?></p>
</div>
<?php endif; ?>

<?php if (validation_errors()) : ?>
<!-- form validation errors -->
<div class="notification error">
        <a href="javascript:viod(0)" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
        <p><strong>Error:</strong> <?php print validation_errors(); ?></p>
</div>
<?php endif; ?>

<?php if (isset($alert)) : ?>
<!-- alert message -->
<div class="notification error">
        <a href="javascript:viod(0)" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
        <p><strong>Alert:</strong> <?php print $msg; ?></p>
</div>
<?php endif; ?>

<?php if (isset($info)) : ?>
<!-- infor. message -->
<div class="notification error">
        <a href="javascript:viod(0)" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
        <p><strong>Information:</strong> <?php print $msg; ?></p>
</div>
<?php endif; ?>

<?php if (isset($note)) : ?>
<!-- note -->
<div class="notification error">
        <a href="javascript:viod(0)" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
        <p><strong>Note:</strong> <?php print $msg; ?></p>
</div>
<?php endif; ?>
