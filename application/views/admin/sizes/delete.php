<div class="cont_heading">
    <h2><?php echo $title ?></h2>
</div>
<p><?php echo lang('realy_delete').'<strong>'.htmlspecialchars($size->name).'</strong>?</p>'?>
<form action="<?php echo current_url() ?>" method="post">
	<p>
		<input type="submit" name="deleteok" value="<?php echo lang('delete');?>" />
		<input type="submit" name="cancel" value="<?php echo lang('cancel')?>" />
	</p>
</form>
