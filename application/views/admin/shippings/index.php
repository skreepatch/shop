<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/shippings/add') ?>" class="add_new">Add new Shipping +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="active">Activated</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($shippings as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/shippings/edit/' . $p->id); ?>" title="Edit this Shipping"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/shipping/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/shippings/edit/' . $p->id); ?>" title="Edit this Shipping"><?php echo icon('edit', 'Edit this Shipping'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/shippings/delete/' . $p->id); ?>" title="Delete this Shipping" class="delete"><?php echo icon('delete', 'Delete this Shipping'); ?></a>
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
