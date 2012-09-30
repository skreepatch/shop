<?php
if (!isset($save_button)) {
    $save_button = 'Save';
}
if (!isset($reset_button)) {
    $reset_button = FALSE;
} else {
    if ($reset_button === TRUE) {
	$reset_button = 'Reset';
    }
}
?>
<?php if (!empty($object->error->all)): ?>
    <div class="error">
        <p>There was an error saving the form.</p>
        <ul><?php foreach ($object->error->all as $k => $err): ?>
		<li><?php echo $err; ?></li>
    <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo $this->config->site_url($url); ?>" enctype="multipart/form-data" method="post">
    <table class="form">
<?php echo $rows; ?>
	<fieldset class="buttons">
	    <input class="white_btn" type="submit" value="<?php echo $save_button; ?>" /><?php
if ($reset_button !== FALSE) {
    ?> <input class="white_btn" type="reset" value="<?php echo $reset_button; ?>" /><?php
}
?>
	    <?php if (isset($_SERVER['HTTP_REFERER'])): ?>
		<a class="white_btn" href="<?php echo $_SERVER['HTTP_REFERER'] ?>" >Discard</a>
	    <?php endif; ?>
	</fieldset>
    </table>
</form>
