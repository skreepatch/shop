<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/statuses/add') ?>" class="add_new">Add new status +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="medex">Medex related</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($statuses as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/statuses/edit/' . $p->id); ?>" title="Edit this status"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/status/'.$p->id.'/medex');?>" title="activate/deactivate"><?php echo $p->medex ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/categories/edit/' . $p->id); ?>" title="Edit this status"><?php echo icon('edit', 'Edit this status'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/categories/delete/' . $p->id); ?>" title="Delete this status" class="delete"><?php echo icon('delete', 'Delete this status'); ?></a>
		</td>
	</tr>
<?php		endforeach; ?>
	<tr>
	    <td class="filter"></td>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['name']) ? $searches['name'] : ''?>"/></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	</tr>
</table>

<?php $this->load->view('admin/pagination');?>
