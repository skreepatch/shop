<div class="cont_heading">
    <h2><?php echo $title ?></h2>
    <a href="<?php echo site_url('admin/tracks/add') ?>" class="add_new"><?php echo lang('add_new') ?></a>
</div>
<div class="top_filters">
    <?php getFilters(array('Product'), FALSE, $dataset['related'], FALSE, $this->language); ?>
</div>
<table class="results">
    <thead>
    <th id="clone" id="clone"><input type="checkbox"  name="cloneall" id="cloneall"/></th>
    <th class="cell" id="id"><?php echo lang('id') ?></th>
    <th class="cell" id="<?php echo 'name_'.$this->language?>"><?php echo lang('track_name') ?></th>
    <th class="cell" id="value"><?php echo lang('track_value') ?></th>
    <th class="cell" id="tracktype_id"><?php echo lang('track_type') ?></th>
    <th class="cell" id="status_id"><?php echo lang('status') ?></th>
    <th class="cell" id="weight"><?php echo lang('weight') ?></th>
    <th id="actions"><?php echo lang('actions') ?></th>
</thead>
<?
$odd = FALSE;
foreach ($tracks as $tr):
    $tr->dbtranslate($this->language);
    $odd = !$odd;
    ?>
    <tr class="<?php echo $odd ? 'odd' : 'even' ?>">
        <td class="name"><input type="checkbox" value="<?php echo $tr->model ?>" name="toclone[<?php echo$tr->id ?>]" class="clone_check"/></td>
        <td class="name"><?php echo htmlspecialchars($tr->id) ?></td>
        <td class="name"><?php echo htmlspecialchars($tr->name) ?></td>
        <td class="name"><?php echo htmlspecialchars($tr->value) ?></td>
        <td class="name"><?php echo htmlspecialchars($tr->tracktype->type) ?></td>
        <td class="name"><?php echo htmlspecialchars($tr->status->name); ?></td>
        <td class="name"><?php echo htmlspecialchars($tr->weight) ?></td>
        <td class="buttons">
            <a href="<?php echo site_url('admin/tracks/edit/' . $tr->id) ?>" title="<?php echo lang('edit') ?>"><?php echo lang('edit') ?></a><span>&nbsp;|&nbsp;</span>
            <a href="<?php echo site_url('admin/tracks/delete/' . $tr->id) ?>" title="<?php echo lang('delete') ?>" class="delete"><?php echo lang('delete') ?></a>
        </td>
    </tr>
<? endforeach; ?>
<tr>
    <td class="cell filter">
	<?php $this->load->view('admin/common/bulkActions');?>
    </td>
    <td class="cell filter"></td>
    <td class="cell filter"></td>
    <td class="cell filter"></td>
    <td class="cell filter"></td>
    <td class="cell filter"></td>
    <td class="cell filter"></td>
    <td class="cell filter"></td>
</tr>
</table>
<?php $this->load->view('admin/pagination'); ?>