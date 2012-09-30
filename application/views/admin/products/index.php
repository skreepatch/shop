<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/products/add') ?>" class="add_new">Add new product +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="category_id">Category</th>
		<th class="cell" id="active">Activated</th>
		<th class="cell" id="bestseller">Bestseller</th>
		<th class="cell" id="isbonus">Bonus</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($products as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/products/edit/' . $p->id); ?>" title="Edit this Product"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="category"><?php echo htmlspecialchars($p->category->name); ?></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/product/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="bestseller"><a href="<?php echo site_url('admin/activator/change/product/'.$p->id.'/bestseller');?>" title="activate/deactivate"><?php echo $p->bestseller ? 'Yes' : 'No'; ?></a></td>
		<td class="isbonus"><a href="<?php echo site_url('admin/activator/change/product/'.$p->id.'/isbonus');?>" title="activate/deactivate"><?php echo $p->isbonus ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/products/edit/' . $p->id); ?>" title="Edit this Product"><?php echo icon('edit', 'Edit this Product'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/products/delete/' . $p->id); ?>" title="Delete this Product" class="delete"><?php echo icon('delete', 'Delete this Product'); ?></a>
		</td>
	</tr>
<?php		endforeach; ?>
	<tr>
	    <td class="filter"></td>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['name']) ? $searches['name'] : ''?>"/></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	</tr>
</table>

<?php $this->load->view('admin/pagination');?>
