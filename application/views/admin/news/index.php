<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/news/add') ?>" class="add_new">Add new news +</a>
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
		foreach($news as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="name"><a href="<?php echo site_url('admin/news/edit/' . $p->id); ?>" title="Edit this news"><?php echo htmlspecialchars($p->name); ?></a></td>
		<td class="date"><?php echo htmlspecialchars($p->date); ?></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/newsitem/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/news/edit/' . $p->id); ?>" title="Edit this news"><?php echo icon('edit', 'Edit this news'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/news/delete/' . $p->id); ?>" title="Delete this news" class="delete"><?php echo icon('delete', 'Delete this news'); ?></a>
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
