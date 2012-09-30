<div class="cont_heading">
    <h2> <?php echo  $title ?></h2>
    <a href=" <?php echo  site_url('admin/sizes/add') ?>" class="add_new"> <?php echo  lang('add_new') ?></a>
</div>
<div class="top_filters">
        <?php getFilters(array('Product', 'Track', 'Printtype'), TRUE, $dataset['related'], FALSE, $this->language);?>
</div>
<table class="results">
    <thead>
    <th id="clone"><input type="checkbox"  name="cloneall" id="cloneall"/></th>
    <th class="cell" id="id"> <?php echo  lang('id') ?></th>
    <th class="cell" id="<?php echo 'name_'.$this->language;?>"> <?php echo  lang('size_name') ?></th>
    <th class="cell" id="width"> <?php echo  lang('size_width') ?></th>
    <th class="cell" id="height"> <?php echo  lang('size_height') ?></th>
    <th class="cell" id="weight"> <?php echo  lang('weight') ?></th>
    <th class="cell" id="status_id"> <?php echo  lang('status') ?></th>
    <th><?php echo  lang('actions') ?></th>
</thead>
<?
$odd = FALSE;
foreach ($sizes as $sz):
    $sz->dbtranslate($this->language);
    $odd = !$odd;
?>
    <tr class=" <?php echo  $odd ? 'odd' : 'even' ?>">
        <td class="name"><input type="checkbox" value="<?php echo  $sz->model?>" name="toclone[<?php echo $sz->id?>]" class="clone_check"/></td>
        <td class="name"> <?php echo  htmlspecialchars($sz->id) ?></td>
        <td class="name"> <?php echo  htmlspecialchars($sz->name) ?></td>
        <td class="name"> <?php echo  htmlspecialchars($sz->width) ?></td>
        <td class="name"> <?php echo  htmlspecialchars($sz->height) ?></td>
        <td class="name"> <?php echo  htmlspecialchars($sz->weight) ?></td>
        <td class="name"> <?php echo  htmlspecialchars($sz->status->name); ?></td>
        <td class="buttons">
        <a href=" <?php echo  site_url('admin/sizes/edit/' . $sz->id) ?>" title=" <?php echo  lang('edit') ?>" > <?php echo  lang('edit') ?></a><span>&nbsp;|&nbsp;</span>
        <a href=" <?php echo  site_url('admin/sizes/delete/' . $sz->id) ?>" title=" <?php echo  lang('delete') ?>" class="delete"> <?php echo  lang('delete') ?></a>
        </td>
</tr>
<? endforeach; ?>
<tr>
            <td class="cell filter"><?php $this->load->view('admin/common/bulkActions');?></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
            <td class="cell filter"></td>
        </tr>
</table>
<?php $this->load->view('admin/pagination');?>