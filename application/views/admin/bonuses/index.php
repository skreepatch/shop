<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/bonuses/add') ?>" class="add_new">Add new bonus +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="price">Price floor</th>
		<th class="cell" id="pills">Pills amount floor</th>
		<th class="cell" id="amount">Amount of bonus pills</th>
		<th class="cell" id="active">Activated</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($bonuses as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/bonuses/edit/' . $p->id); ?>" title="Edit this Bonus"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="price"><?php echo $p->price?></td>
		<td class="pills"><?php echo $p->pills?></td>
		<td class="amount"><?php echo $p->amount?></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/bonus/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/bonuses/edit/' . $p->id); ?>" title="Edit this Bonus"><?php echo icon('edit', 'Edit this Bonus'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/bonuses/delete/' . $p->id); ?>" title="Delete this Bonus" class="delete"><?php echo icon('delete', 'Delete this Bonus'); ?></a>
		</td>
	</tr>
<?php		endforeach; ?>
	<tr>
	    <td class="filter"><input type="text" name="id" value="<?php echo isset($searches['id']) ? $searches['id'] : ''?>"/></td>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['name']) ? $searches['name'] : ''?>"/></td>
	    <td class="filter"><input type="text" name="price" value="<?php echo isset($searches['price']) ? $searches['price'] : ''?>"/></td>
	    <td class="filter"><input type="text" name="pills" value="<?php echo isset($searches['pills']) ? $searches['pills'] : ''?>"/></td>
	    <td class="filter"><input type="text" name="amount" value="<?php echo isset($searches['amount']) ? $searches['amount'] : ''?>"/></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	</tr>
</table>

<?php $this->load->view('admin/pagination');?>
