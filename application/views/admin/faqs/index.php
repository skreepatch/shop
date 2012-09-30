<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/faqs/add') ?>" class="add_new">Add new faq +</a>
</div>

<table class="results">
	<thead>
		<th class="cell" id="id">Id</th>
		<th class="cell" id="name">Question</th>
		<th class="cell" id="date">Answer</th>
		<th class="cell" id="active">Activated</th>
		<th class="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($faqs as $p):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="id"><?php echo $p->id?></td>
		<td class="question"><a href="<?php echo site_url('admin/faqs/edit/' . $p->id); ?>" title="Edit this testimonial"><?php echo htmlspecialchars($p->question); ?></a></td>
		<td class="answer"><?php echo htmlspecialchars($p->answer); ?></td>
		<td class="active"><a href="<?php echo site_url('admin/activator/change/faqs/'.$p->id.'/active');?>" title="activate/deactivate"><?php echo $p->active ? 'Yes' : 'No'; ?></a></td>
		<td class="buttons">
		    <a href="<?php echo site_url('admin/faqs/edit/' . $p->id); ?>" title="Edit this faq"><?php echo icon('edit', 'Edit this faq'); ?></a>
		    &nbsp;
		    <a href="<?php echo site_url('admin/faqs/delete/' . $p->id); ?>" title="Delete this faq" class="delete"><?php echo icon('delete', 'Delete this faq'); ?></a>
		</td>
	</tr>
<?php		endforeach; ?>
	<tr>
	    <td class="filter"></td>
	    <td class="filter"><input type="text" name="name" value="<?php echo isset($searches['question']) ? $searches['question'] : ''?>"/></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	    <td class="filter"></td>
	</tr>
</table>

<?php $this->load->view('admin/pagination');?>
