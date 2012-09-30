<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/categories/add') ?>" class="add_new">Add new category +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="active">Activated</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($categories as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/categories/edit/' . $p->id); ?>" title="Edit this Category"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/category/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/categories/edit/' . $p->id); ?>" title="Edit this Category"><?php echo icon('edit', 'Edit this Category'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/categories/delete/' . $p->id); ?>" title="Delete this Category" class="delete"><?php echo icon('delete', 'Delete this Category'); ?></a>
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
