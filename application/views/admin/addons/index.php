<div class="cont_heading">
    <h2><?php echo $title ?></h2>
    <a href="<?php echo  site_url('admin/addons/add') ?>" class="add_new"><?php echo  lang('add_new') ?></a>
</div>
<div class="top_filters">
        <?php getFilters(array('Product'), FALSE, $dataset['related'], FALSE, $this->language);?>
</div>
<table class="results">
<thead>
    <th class="clone" id="clone"><input type="checkbox"  name="cloneall" id="cloneall"/></th>
    <th class="cell" id="id"><?php echo  lang('id') ?></th>
    <th class="cell" id="<?php echo 'label_'.$this->language;?>"><?php echo  lang('label') ?></th>
    <th class="cell" id="price_settings"><?php echo  lang('addon_options') ?></th>
    <th class="cell" id="actions"><?php echo  lang('actions') ?></th>
</thead>
<?
$odd = FALSE;
foreach ($addons as $am):
    $am->dbtranslate($this->language);
    $odd = !$odd;
?>
<tbody>
    <tr class="<?php echo  $odd ? 'odd' : 'even' ?>">
        <td class="name"><input type="checkbox" value="<?php echo $am->model?>" name="toclone[<?php echo $am->id?>]" class="clone_check"/></td>
        <td class="cell"><?php echo  $am->id ?></td>
        <td class="cell"><?php echo  $am->addon_label ?></td>
        <td class="cell">
            <a href="<?php echo   site_url('admin/addons/options/'.$am->id)?>" title=""><?php echo lang('edit_addon_options')?></a>
        </td>
        <td class="buttons">
            <a href="<?php echo  site_url('admin/addons/edit/' . $am->id) ?>" title="<?php echo  lang('edit') ?>"><?php echo  lang('edit') ?></a><span>&nbsp;|&nbsp;</span>
            <a href="<?php echo  site_url('admin/addons/delete/' . $am->id) ?>" title="<?php echo  lang('delete') ?>" class="delete"><?php echo  lang('delete') ?></a>
        </td>
</tr>
<? endforeach; ?>
        <tr>
            <td class="cell filter"><?php $this->load->view('admin/common/bulkActions');?></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
        </tr>
        </tbody>
</table>

<?php $this->load->view('admin/pagination'); ?>