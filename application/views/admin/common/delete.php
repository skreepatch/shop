<p>Are you sure you want to delete the <?php echo $obj->model?> <strong><?php echo htmlspecialchars($obj->name); ?></strong>?</p>
<form action="<?php echo current_url(); ?>" method="post">
	<p>
		<input type="submit" name="deleteok" value="Yes, Delete the <?php echo $obj->model?>" />
		<input type="submit" name="cancel" value="Cancel" />
	</p>
</form>
