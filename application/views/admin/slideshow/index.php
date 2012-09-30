<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/slideshow/add') ?>" class="add_new">Add new slide +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="label">Label</th>
		<th class="cell" id="image">Image</th>
		<th class="cell" id="active">Activated</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($slides as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="label"><a href="<?php echo site_url('admin/slideshow/edit/' . $p->id); ?>" title="Edit this Slide"><?php echo htmlspecialchars($p->label); ?></a></td>
		<td class="image"><?php echo htmlspecialchars($p->image); ?></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/slide/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/slideshow/edit/' . $p->id); ?>" title="Edit this Slide"><?php echo icon('edit', 'Edit this Slide'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/slideshow/delete/' . $p->id); ?>" title="Delete this Slide" class="delete"><?php echo icon('delete', 'Delete this Slide'); ?></a>
		</td>
	</tr>
<?php		endforeach; ?>
	<tr>
	    <td class="filter"></td>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['name']) ? $searches['name'] : ''?>"/></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	</tr>
</table>

<?php $this->load->view('admin/pagination');?>
