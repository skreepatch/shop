<div class="cont_heading">
    <h2><?php echo $title?></h2>
    <a href="<?php echo site_url('admin/users/add') ?>" class="add_new">Add new User +</a>
</div>
<table class="results">
	<thead>
		<th class="cell" id="name">Name</th>
		<th class="cell" id="email">Email</th>
		<th class="cell" id="group">Group</th>
		<th class="cell" id="buttons">Options</th>
	</thead>
<?php		$odd = FALSE;
		foreach($users as $u):
			$odd = !$odd;
		?>
	<tr class="<?php echo $odd ? 'odd' : 'even'; ?>">
		<td class="name"><a href="<?php echo site_url('admin/users/edit/' . $u->id); ?>" title="Edit this User"><?php echo htmlspecialchars($u->name); ?></a><?php
			if($u->id == $this->login_manager->get_user()->id) {
				echo(' *');
			}
		?></td>
		<td class="email"><a href="mailto:<?php echo htmlspecialchars($u->email); ?>"><?php echo htmlspecialchars($u->email); ?></a></td>
		<td class="group"><?php echo htmlspecialchars($u->group_name); ?></td>
		<td class="buttons"><a href="<?php echo site_url('admin/users/edit/' . $u->id); ?>" title="Edit this User"><?php echo icon('edit', 'Edit this User'); ?></a><?php
			if($u->id != $this->login_manager->get_user()->id) {
				?> &nbsp; <a href="<?php echo site_url('admin/users/delete/' . $u->id); ?>" title="Delete this User"><?php echo icon('delete', 'Delete this User'); ?></a><?php
			} ?></td>
	</tr>
<?php		endforeach; ?>
</table>
<p>* My Account</p>
