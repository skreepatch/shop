<div class="cont_heading">
    <h2><?= $title ?></h2>
</div>
<p><?=lang('realy_delete')?><strong><?= htmlspecialchars($addon->addon_label) ?></strong>?</p>
<form action="<?= current_url() ?>" method="post">
	<p>
		<input type="submit" name="deleteok" value="<?=lang('delete');?>" />
		<input type="submit" name="cancel" value="<?=lang('cancel')?>" />
	</p>
</form>
