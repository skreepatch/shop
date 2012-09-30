<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/testimonials/add') ?>" class="add_new">Add new testimonial +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="date">Date</th>
		<th class="cell" id="active">Activated</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($testimonials as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/testimonials/edit/' . $p->id); ?>" title="Edit this testimonial"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="date"><?php echo htmlspecialchars($p->date); ?></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/testimonial/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/testimonials/edit/' . $p->id); ?>" title="Edit this testimonial"><?php echo icon('edit', 'Edit this testimonial'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/testimonials/delete/' . $p->id); ?>" title="Delete this testimonial" class="delete"><?php echo icon('delete', 'Delete this testimonial'); ?></a>
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
